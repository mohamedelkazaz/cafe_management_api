<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

// مسارات محمية بـ JWT
Route::middleware('auth.jwt')->group(function () {
    Route::apiResource('items', ItemController::class);
    Route::apiResource('orders', OrderController::class)->only(['index', 'store']);

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
