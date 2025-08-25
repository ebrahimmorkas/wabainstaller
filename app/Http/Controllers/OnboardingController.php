<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\WabaAccount;
use App\Models\PhoneNumber;
use App\Models\MessageTemplate;
use App\Models\BusinessVerification;
use App\Models\PhoneNumberProfile;
use Illuminate\Support\Facades\DB;

class OnboardingController extends Controller
{
    /**
     * Decide which stage to send the user to.
     */
    // In OnboardingController
    public function testWebhook()
    {
        \Illuminate\Support\Facades\Cache::put('waba_webhook_verified', true, now()->addDays(7));
        return back()->with('success', 'Webhook marked verified (dev test).');
    }

    public function index(Request $request)
    {
        $waba = WabaAccount::latest('id')->first();

        if (!$waba) {
            return redirect()->route('onboarding.create');
        }

        // If WABA exists but missing ID or token -> connect stage
        if (blank($waba->waba_id) || blank($waba->access_token)) {
            return redirect()->route('onboarding.connect', $waba->id);
        }

        // If no numbers synced -> numbers stage
        $numbersCount = PhoneNumber::where('whatsapp_business_account_id', $waba->waba_id)->count();
        if ($numbersCount === 0) {
            return redirect()->route('onboarding.numbers', $waba->id);
        }

        // Otherwise show finish (summary)
        return redirect()->route('onboarding.finish', $waba->id);
    }

    /**
     * Step: Create WABA record (name-only).
     */
    public function showCreate()
    {
        return view('onboarding.create');
    }

    public function storeCreate(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:191'],
        ]);

        $waba = WabaAccount::create([
            'name' => $data['name'],
            'waba_id' => null,
            'access_token' => null,
        ]);

        return redirect()->route('onboarding.connect', $waba->id)
            ->with('success', 'Account created. Now connect to Meta (WABA ID + Access Token).');
    }

    /**
     * Step: Connect WABA (add waba_id + token).
     */
    public function showConnect(WabaAccount $waba)
    {
        return view('onboarding.connect', compact('waba'));
    }

    public function storeConnect(Request $request, WabaAccount $waba)
    {
        $data = $request->validate([
            'waba_id'      => ['required','string','max:191'],
            'access_token' => ['required','string'],
        ]);

        $waba->update($data);

        // TODO: live verify via Meta Graph (optional now)
        // If verify fails: return back()->withErrors(['access_token' => 'Invalid token or WABA ID']);

        return redirect()->route('onboarding.numbers', $waba->id)
            ->with('success', 'WABA connected. You can now sync phone numbers.');
    }

    /**
     * Step: Numbers management & sync.
     */
    public function showNumbers(WabaAccount $waba)
    {
        $numbers = PhoneNumber::where('whatsapp_business_account_id', $waba->waba_id)->orderBy('display_phone_number')->get();
        return view('onboarding.numbers', compact('waba', 'numbers'));
    }

    public function syncNumbers(Request $request, WabaAccount $waba)
    {
        // NOTE: This is a stub. Replace with live Graph API calls later.
        // Simulate fetching 1–2 numbers if empty.
        if (PhoneNumber::where('whatsapp_business_account_id', $waba->waba_id)->count() === 0) {
            PhoneNumber::updateOrCreate(
                ['phone_number_id' => 'PHONE_ID_1'],
                [
                    'display_phone_number' => '+91 98765 43210',
                    'whatsapp_business_account_id' => $waba->waba_id,
                    'waba_name' => $waba->name,
                    'verified_name' => $waba->name,
                    'code_verification_status' => 'VERIFIED',
                    'quality_rating' => 'GREEN',
                    'platform_type' => 'CLOUD_API',
                    'throughput_level' => 'TIER_1',
                    'is_official_business_account' => false,
                    'messaging_limit_tier' => '1K',
                    'token' => null,
                    'status' => 'inactive',
                ]
            );
        }

        return back()->with('success', 'Phone numbers synced.');
    }

    public function toggleNumberStatus(Request $request, $phoneNumberId)
    {
        $number = PhoneNumber::where('phone_number_id', $phoneNumberId)->firstOrFail();
        $number->status = $number->status === 'active' ? 'inactive' : 'active';
        $number->save();

        return back()->with('success', "Number {$number->display_phone_number} is now {$number->status}.");
    }

    /**
     * Step: Business Verification sync.
     */
    public function syncVerification(Request $request, WabaAccount $waba)
    {
        // TODO: Replace with Graph API call to fetch verification status
        BusinessVerification::updateOrCreate(
            ['whatsapp_business_account_id' => $waba->waba_id],
            ['name' => $waba->name, 'verification_status' => 'PENDING', 'updated_at' => now()]
        );

        return back()->with('success', 'Business verification synced.');
    }

    /**
     * Step: Profiles sync (per number).
     */
    public function syncProfiles(Request $request, WabaAccount $waba)
    {
        $numbers = PhoneNumber::where('whatsapp_business_account_id', $waba->waba_id)->get();

        foreach ($numbers as $num) {
            PhoneNumberProfile::updateOrCreate(
                ['phone_number_id' => $num->phone_number_id],
                [
                    'about' => 'About us…',
                    'address' => 'Your business address',
                    'description' => 'Short description',
                    'email' => 'info@example.com',
                    'profile_picture_url' => null,
                    'websites' => json_encode(['https://example.com']),
                    'vertical' => 'services',
                ]
            );
        }

        return back()->with('success', 'Phone profiles synced.');
    }

    /**
     * Templates listing & sync.
     */
    public function showTemplates(WabaAccount $waba)
    {
        $templates = MessageTemplate::where('waba_id', $waba->waba_id)
            ->orderBy('name')->get();

        return view('onboarding.templates', compact('waba', 'templates'));
    }

    public function syncTemplates(Request $request, WabaAccount $waba)
    {
        // TODO: Replace with Graph API call
        MessageTemplate::updateOrCreate(
            ['waba_id' => $waba->waba_id, 'name' => 'welcome', 'language' => 'en_US'],
            [
                'category' => 'MARKETING',
                'status' => 'APPROVED',
                'quality_score' => 'HIGH',
                'components' => json_encode([]),
                'component_data' => json_encode(['sample' => true]),
            ]
        );

        return back()->with('success', 'Templates synced.');
    }

    /**
     * Summary screen.
     */
    public function finish(WabaAccount $waba)
    {
        $numbersActive = PhoneNumber::where('whatsapp_business_account_id', $waba->waba_id)
            ->where('status', 'active')->count();

        $templatesCount = MessageTemplate::where('waba_id', $waba->waba_id)->count();
        $verification = BusinessVerification::where('whatsapp_business_account_id', $waba->waba_id)->first();

        return view('onboarding.finish', compact('waba', 'numbersActive', 'templatesCount', 'verification'));
    }
}
