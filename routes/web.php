<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to dashboard (clean entry point)
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// DASHBOARD (MAIN SYSTEM PAGE)
Route::get('/dashboard', [AssetController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


// PROTECTED ROUTES (require login)
Route::middleware(['auth'])->group(function () {

    // Asset routes
    Route::get('/assets/create', [AssetController::class, 'create']);
    Route::post('/assets', [AssetController::class, 'store']);
    Route::get('/assets/{id}/edit', [AssetController::class, 'edit']);
    Route::put('/assets/{id}', [AssetController::class, 'update']);
    Route::delete('/assets/{id}', [AssetController::class, 'destroy']);

    // Profile routes (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes (login/register/logout)
require __DIR__.'/auth.php';