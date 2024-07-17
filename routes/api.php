<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TransferController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/set-account', [SessionController::class, 'setSelectedAccount'])->name('set-account');
    Route::post('/make-transfer', [TransferController::class, 'makeTransfer'])->name('make-transfer');
});