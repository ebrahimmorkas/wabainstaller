<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WabaAccount;

class SetupWizardController extends Controller
{
    /**
     * Optional: unified wizard entry that forwards into onboarding flow.
     */
    public function index(Request $request)
    {
        $waba = WabaAccount::latest('id')->first();

        if (!$waba) {
            return redirect()->route('onboarding.create');
        }

        if (blank($waba->waba_id) || blank($waba->access_token)) {
            return redirect()->route('onboarding.connect', $waba->id);
        }

        return redirect()->route('onboarding.numbers', $waba->id);
    }
}
