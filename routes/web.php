<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    $statePath = storage_path('app/installer/state.json');
    $installed = File::exists($statePath) && (json_decode(File::get($statePath), true)['installed'] ?? false);

    return $installed ? redirect('/login') : redirect('/install');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// routes/web.php (temporary)
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', function() {
    // demo login: just redirect home
    return redirect('/');
});

Route::get('/', function () {
    // If you already wrote logic to redirect to /install or /login, keep it.
    return redirect('/login');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard'); // simple landing page
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.index'))->name('dashboard');
});

// Route::get('/', function () {
//     return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
// });


// keep this at the bottom
require __DIR__.'/install.php';
