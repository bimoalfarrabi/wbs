<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WbsController;
use App\Http\Controllers\Auth\LoginController;

// Public Routes
Route::get('/', [WbsController::class, 'create'])->name('wbs.create');
Route::post('/', [WbsController::class, 'store'])->name('wbs.store');

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
