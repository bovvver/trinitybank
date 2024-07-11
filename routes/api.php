<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

Route::post('/set-account', [SessionController::class, 'setSelectedAccount'])->middleware('auth:sanctum')->name('set-account');