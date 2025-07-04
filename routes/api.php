<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\EmployeeController;


Route::post('/login', [AuthController::class, 'login']);

// مسارات محمية بـ JWT
Route::middleware('auth:api')->group(function () {
    Route::apiResource('items', ItemController::class);
    Route::apiResource('orders', OrderController::class)->only(['index', 'store']);

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::apiResource('tables', TableController::class);
Route::apiResource('raw-materials', RawMaterialController::class);
Route::apiResource('employees', EmployeeController::class);


