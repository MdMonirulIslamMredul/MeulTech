<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;

// Public home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Breeze authentication routes are loaded separately from routes/auth.php.
require __DIR__ . '/auth.php';

// User profile route (protected)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/profile', 'profile')->name('profile');
});

// Admin area protected by auth + role middleware (only Admin/Staff/Super Admin)
Route::middleware(['auth', 'verified', 'role:Super Admin|Admin|Staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
