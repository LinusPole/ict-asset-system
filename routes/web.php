<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard (Main system page)
Route::get('/dashboard', [AssetController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


// AUTH PROTECTED ROUTES
Route::middleware(['auth'])->group(function () {

    // Asset routes
    Route::get('/assets/create', [AssetController::class, 'create']);
    Route::post('/assets', [AssetController::class, 'store']);
    Route::get('/assets/{id}/edit', [AssetController::class, 'edit']);
    Route::put('/assets/{id}', [AssetController::class, 'update']);
    Route::delete('/assets/{id}', [AssetController::class, 'destroy']);

    // Export routes
    Route::get('/assets/export/pdf', [AssetController::class, 'exportPDF']);
    Route::get('/assets/export/excel', [AssetController::class, 'exportExcel']);

    // ADMIN ONLY ROUTES
    Route::middleware(['admin'])->group(function () {
        Route::get('/assets/history', [AssetController::class, 'history']);
    });

    // Profile routes (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';