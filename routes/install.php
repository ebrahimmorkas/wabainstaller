<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallerController;
use App\Http\Middleware\EnsureNotInstalled;
use App\Http\Middleware\EnsureInstalled;
use App\Http\Controllers\Auth\LoginController;

// Installer flow (only when NOT installed)
Route::middleware(['web', EnsureNotInstalled::class])
    ->prefix('install')->group(function () {
        Route::get('/', fn () => redirect()->route('install.step1'));
        Route::get('/step1', [InstallerController::class,'step1'])->name('install.step1');
        Route::post('/step1', [InstallerController::class,'step1Post']);

        Route::get('/step2',  [InstallerController::class,'step2'])->name('install.step2');
        Route::post('/step2', [InstallerController::class,'step2Post']);
        Route::post('/step2/run', [InstallerController::class,'step2Run'])->name('install.step2.run');

        Route::get('/step3',  [InstallerController::class,'step3'])->name('install.step3');
        Route::post('/step3/verify', [InstallerController::class,'verifyLicense'])->name('install.step3.verify');

        Route::get('/step4',  [InstallerController::class,'step4'])->name('install.step4');
        Route::post('/step4', [InstallerController::class,'step4Post'])->name('install.step4.post');

        
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
    });

// Success page (only when installed)
Route::middleware(['web', EnsureInstalled::class])
    ->prefix('install')->group(function () {
        Route::get('/final', [InstallerController::class,'final'])->name('install.final');
    });
