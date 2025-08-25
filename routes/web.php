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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/setup', [SetupWizardController::class, 'index'])->name('setup');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // ⬇️ use class instead of 'admin'
    Route::middleware(AdminMiddleware::class)->prefix('onboarding')->name('onboarding.')->group(function () {

        Route::get('/', [OnboardingController::class, 'index'])->name('index');

        Route::get('/create',  [OnboardingController::class, 'showCreate'])->name('create');
        Route::post('/create', [OnboardingController::class, 'storeCreate'])->name('create.store');

        Route::get('/connect/{waba}', [OnboardingController::class, 'showConnect'])->name('connect');
        Route::post('/connect',        [OnboardingController::class, 'storeConnect'])->name('connect.store'); // no {waba}

        Route::get('/numbers/{waba}',          [OnboardingController::class, 'showNumbers'])->name('numbers');
        Route::post('/numbers/{waba}/sync',    [OnboardingController::class, 'syncNumbers'])->name('numbers.sync');
        Route::post('/numbers/{phoneNumberId}/toggle', [OnboardingController::class, 'toggleNumberStatus'])->name('numbers.toggle');

        Route::post('/{waba}/verification/sync', [OnboardingController::class, 'syncVerification'])->name('verification.sync');
        Route::post('/{waba}/profiles/sync',     [OnboardingController::class, 'syncProfiles'])->name('profiles.sync');

        Route::get('/templates/{waba}',  [OnboardingController::class, 'showTemplates'])->name('templates');
        Route::post('/templates/{waba}/sync', [OnboardingController::class, 'syncTemplates'])->name('templates.sync');

        Route::get('/finish/{waba}', [OnboardingController::class, 'finish'])->name('finish');
    });
});

/*
|--------------------------------------------------------------------------
| Installer routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/install.php';
