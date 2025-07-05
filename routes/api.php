<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;




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
Route::get('/reports/summary', [OrderController::class, 'reportSummary']);
Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
Route::get('/orders/report', [OrderController::class, 'report']);
Route::get('/dashboard/stats', [OrderController::class, 'dashboardStats']);
Route::middleware('auth.jwt')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});
Route::get('/orders/status/{status}', [OrderController::class, 'filterByStatus']);
Route::get('/orders/status/{status}', [OrderController::class, 'getByStatus']);
Route::get('/orders/summary', [OrderController::class, 'summary']);


