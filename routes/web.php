<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WbsController;
use App\Http\Controllers\Auth\LoginController;

// Public Routes
Route::get('/', [WbsController::class, 'create'])->name('wbs.create');
Route::post('/', [WbsController::class, 'store'])->name('wbs.store');

Route::get('/debug-upload-config', function () {
    return response()->json([
        'post_max_size' => ini_get('post_max_size'),
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'max_file_uploads' => ini_get('max_file_uploads'),
        'memory_limit' => ini_get('memory_limit'),
        'max_execution_time' => ini_get('max_execution_time'),
    ]);
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
