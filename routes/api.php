<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/set-account', [SessionController::class, 'setSelectedAccount'])->name('set-account');
});