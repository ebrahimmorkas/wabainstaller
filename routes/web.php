<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SetupWizardController;
use App\Http\Controllers\Webhook\WabaWebhookController;

/*
|--------------------------------------------------------------------------
| Installer gate on root
| If not installed -> /install
| If installed     -> redirect to /dashboard (when authed) or /login
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $statePath = storage_path('app/installer/state.json');
    $installed = File::exists($statePath) && ((json_decode(File::get($statePath), true)['installed'] ?? false) === true);

    if (! $installed) {
        return redirect('/install');
    }

    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Auth (guest)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| Public Webhook endpoints (Meta must reach these)
|--------------------------------------------------------------------------
*/
Route::get('/webhook/waba',  [WabaWebhookController::class, 'verify']);
Route::post('/webhook/waba', [WabaWebhookController::class, 'receive']);

/*
|--------------------------------------------------------------------------
| Authenticated area
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard is controller-driven so it can render the onboarding wizard inside
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Optional: quick entry to the wizard (redirects to the right stage)
    Route::get('/setup', [SetupWizardController::class, 'index'])->name('setup');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Onboarding (semantic routes; no step-1/step-2)
    |--------------------------------------------------------------------------
    | Note: Even though the wizard UI is embedded in /dashboard, these routes
    | handle the POST actions and (optionally) deep links.
    */
    Route::middleware('admin')->prefix('onboarding')->name('onboarding.')->group(function () {

        // Auto-redirect to the appropriate stage based on current state
        Route::get('/', [OnboardingController::class, 'index'])->name('index');

        // 1) Create WABA record (name-only)
        Route::get('/create', [OnboardingController::class, 'showCreate'])->name('create');
        Route::post('/create', [OnboardingController::class, 'storeCreate'])->name('create.store');

        // 2) Connect WABA (add waba_id + access_token)
        Route::get('/connect/{waba}', [OnboardingController::class, 'showConnect'])->name('connect');
        Route::post('/connect/{waba}', [OnboardingController::class, 'storeConnect'])->name('connect.store');

        // 3) Numbers: view/sync/toggle
        Route::get('/numbers/{waba}', [OnboardingController::class, 'showNumbers'])->name('numbers');
        Route::post('/numbers/{waba}/sync', [OnboardingController::class, 'syncNumbers'])->name('numbers.sync');
        Route::post('/numbers/{phoneNumberId}/toggle', [OnboardingController::class, 'toggleNumberStatus'])->name('numbers.toggle');

        // 4) Business verification sync
        Route::post('/{waba}/verification/sync', [OnboardingController::class, 'syncVerification'])->name('verification.sync');

        // 5) Phone number profiles sync
        Route::post('/{waba}/profiles/sync', [OnboardingController::class, 'syncProfiles'])->name('profiles.sync');

        // 6) Templates: list/sync
        Route::get('/templates/{waba}', [OnboardingController::class, 'showTemplates'])->name('templates');
        Route::post('/templates/{waba}/sync', [OnboardingController::class, 'syncTemplates'])->name('templates.sync');

        // 7) Finish summary
        Route::get('/finish/{waba}', [OnboardingController::class, 'finish'])->name('finish');
    });
});

/*
|--------------------------------------------------------------------------
| Installer routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/install.php';
