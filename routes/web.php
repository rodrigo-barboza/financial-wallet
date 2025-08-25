<?php

use App\Http\Controllers\DepositController;
use App\Http\Controllers\ListTransactionsController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn() => Auth::check()
    ? redirect(route('home', absolute: false))
    : redirect()->intended(route('login', absolute: false))
);

Route::middleware('auth')->group(function () {
    Route::get('home', fn() => Inertia::render('Home'))->name('home');

    Route::post('/deposit', DepositController::class)->name('deposit');
    Route::post('/transfer', TransferController::class)->name('transfer');
    Route::get('/transactions', ListTransactionsController::class)->name('transactions');
});

require __DIR__.'/auth.php';
