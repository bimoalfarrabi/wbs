<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WbsController;
use App\Http\Controllers\Auth\LoginController;

// Public Routes
Route::get('/', [WbsController::class, 'create'])->name('wbs.create');
Route::post('/', [WbsController::class, 'store'])->name('wbs.store');

Route::get('/debug-logs', function () {
    $path = storage_path('logs/laravel.log');
    if (!file_exists($path)) {
        return 'Log file not found.';
    }
    $content = file_get_contents($path);
    // Get last 200 lines
    $lines = explode("\n", $content);
    $lines = array_slice($lines, -200);
    return '<pre>' . implode("\n", $lines) . '</pre>';
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [WbsController::class, 'index'])->name('wbs.index');

    // Superadmin Routes
    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
    });
});
