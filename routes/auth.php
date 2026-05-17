<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| These routes are intentionally separated from `routes/web.php` to keep
| authentication concerns isolated and to match a Breeze-friendly structure.
| If you install Laravel Breeze, it will populate equivalent auth flows.
|
*/

Route::middleware('guest')->group(function () {
    // Breeze will typically provide these routes and controllers.
    // Keep the file as a clean route entry-point for future auth adjustments.
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home');
    })->name('logout');
});
