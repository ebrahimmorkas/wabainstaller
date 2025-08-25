<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\WabaAccount;
use App\Models\PhoneNumber;
use App\Models\MessageTemplate;
use App\Models\BusinessVerification;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Default vars so blade never explodes
        $waba = null;
        $numbers = collect();
        $numbersActive = 0;
        $templatesCount = 0;
        $verification = null;
        $stage = 'ready';

        // If tables aren’t there yet, show a soft prompt
        foreach (['waba_accounts','phone_numbers','message_templates','business_verifications'] as $t) {
            if (! Schema::hasTable($t)) {
                $stage = 'needs_migration';
                return view('dashboard.index', compact('waba','stage','numbers','numbersActive','templatesCount','verification'));
            }
        }

        // Decide the current stage
        $waba = WabaAccount::latest('id')->first();

        if (!$waba) {
            $stage = 'create';                         // name-only
        } elseif (blank($waba->waba_id) || blank($waba->access_token)) {
            $stage = 'connect';                        // waba_id + token
        } else {
            $numbers = PhoneNumber::where('whatsapp_business_account_id', $waba->waba_id)->orderBy('display_phone_number')->get();
            if ($numbers->isEmpty()) {
                $stage = 'numbers';                    // sync numbers
            } else {
                $numbersActive  = $numbers->where('status','active')->count();
                $templatesCount = MessageTemplate::where('waba_id', $waba->waba_id)->count();
                $verification   = BusinessVerification::where('whatsapp_business_account_id', $waba->waba_id)->first();
                $stage = $numbersActive > 0 ? 'ready' : 'numbers';
                if ($templatesCount === 0) {
                    $stage = 'templates';              // ensure templates synced at least once
                }
            }
        }

        return view('dashboard.index', compact('waba','stage','numbers','numbersActive','templatesCount','verification'));
    }
}
