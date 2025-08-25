<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use App\Models\WabaAccount;
use App\Models\PhoneNumber;
use App\Models\MessageTemplate;

class DashboardController extends Controller
{
    public function storeConnect(Request $request)
    {
        $data = $request->validate([
            'waba_id'      => 'required|string|max:191',
            'access_token' => 'required|string',
        ]);

        // Single-tenant assumption: update existing WABA if present, else create one
        $waba = WabaAccount::first(); // or WabaAccount::latest('id')->first();
        if (! $waba) {
            $waba = new WabaAccount();
            $waba->name = 'Primary WABA';
        }

        $waba->waba_id      = $data['waba_id'];
        $waba->access_token = $data['access_token'];
        $waba->save();

        return redirect()->route('dashboard')
            ->with('success', 'WABA connected. Continue to Webhook verification.');
    }

   public function index(Request $request)
{
    $waba = null;
    $numbers = collect();
    $numbersActive = 0;
    $templatesCount = 0;

    foreach (['waba_accounts','phone_numbers','message_templates'] as $t) {
        if (! \Illuminate\Support\Facades\Schema::hasTable($t)) {
            return view('dashboard.index', [
                'stage' => 'needs_migration',
                'waba' => null,
                'numbers' => collect(),
                'numbersActive' => 0,
                'templatesCount' => 0,
            ]);
        }
    }

    $waba = \App\Models\WabaAccount::latest('id')->first();
    $webhookVerified = (bool) \Illuminate\Support\Facades\Cache::get('waba_webhook_verified', false);

    if (! $waba || blank($waba->waba_id) || blank($waba->access_token)) {
        $stage = 'connection';                 // Step 1: WABA ID + Access Token
    } elseif (! $webhookVerified) {
        $stage = 'webhook';                    // Step 2: Webhook verify
    } else {
        $numbers = \App\Models\PhoneNumber::where('whatsapp_business_account_id', $waba->waba_id)->get();
        if ($numbers->isEmpty()) {
            $stage = 'numbers';                // Step 3: Sync/link numbers
        } else {
            $numbersActive  = $numbers->where('status','active')->count();
            $templatesCount = \App\Models\MessageTemplate::where('waba_id', $waba->waba_id)->count();
            $stage = 'finish';                 // Step 4: Test & finish (show dashboard after this)
        }
    }

    return view('dashboard.index', compact('stage','waba','numbers','numbersActive','templatesCount'));
}

}
