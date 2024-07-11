<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('index');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AccountController::class, 'index'])->name('dashboard');
    Route::get('/history', [AccountController::class, 'history'])->name('history');
    Route::get('/cards', [AccountController::class, 'cards'])->name('cards');
    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::get('/transfer', [TransferController::class, 'index'])->name('transfer');
});

require __DIR__ . '/auth.php';
