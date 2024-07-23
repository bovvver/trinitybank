<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TransferController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/set-account', [SessionController::class, 'setSelectedAccount'])->name('set-account');
    Route::post('/make-transfer', [TransferController::class, 'makeTransfer'])->name('make-transfer');
    Route::post('/create-card', [AccountController::class, 'createCard'])->name('create-card');
    Route::post('/upload-avatar', [AccountController::class, 'uploadAvatar'])->name('upload-avatar');
    
    Route::patch('/update-card', [AccountController::class, 'updateCard'])->name('update-card');
    Route::patch('/update-contact', [AccountController::class, 'updateContact'])->name('update-contact');
});