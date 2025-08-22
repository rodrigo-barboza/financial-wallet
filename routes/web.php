<?php

use App\Http\Controllers\DepositController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn() => Auth::check()
    ? redirect(route('home', absolute: false))
    : redirect()->intended(route('login', absolute: false))
);

Route::middleware('auth')->group(function () {
    Route::get('home', fn() => Inertia::render('Home'))->name('home');

    Route::post('/deposit', [DepositController::class, 'store'])->name('deposit');
});

require __DIR__.'/auth.php';
