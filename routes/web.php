<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WbsController;

Route::get('/', [WbsController::class, 'create'])->name('wbs.create');
Route::post('/', [WbsController::class, 'store'])->name('wbs.store');
Route::get('/dashboard', [WbsController::class, 'index'])->name('wbs.index');
