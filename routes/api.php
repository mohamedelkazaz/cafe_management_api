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
use Illuminate\Support\Facades\Auth;

// تسجيل الدخول
Route::post('/login', [AuthController::class, 'login']);

// مسارات محمية بـ JWT
Route::middleware('auth:api')->group(function () {
    Route::apiResource('items', ItemController::class);
    Route::apiResource('orders', OrderController::class)->only(['index', 'store']);

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // إدارة المستخدمين
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // إخفاء/إظهار منتج
    Route::patch('/items/{id}/toggle', [ItemController::class, 'toggleVisibility']);
    Route::put('/items/{id}/visibility', [ItemController::class, 'toggleVisibility']);

    // حذف صنف كأدمين
    Route::delete('/admin/items/{id}', [ItemController::class, 'destroy']);
});

// موارد عامة (غير محمية)
Route::apiResource('tables', TableController::class);
Route::apiResource('raw-materials', RawMaterialController::class);
Route::apiResource('employees', EmployeeController::class);
Route::get('/reports/summary', [OrderController::class, 'reportSummary']);
Route::get('/dashboard/stats', [OrderController::class, 'dashboardStats']);
Route::get('/orders/report', [OrderController::class, 'report']);
Route::get('/orders/status/{status}', [OrderController::class, 'getByStatus']);
Route::get('/orders/summary', [OrderController::class, 'summary']);
Route::get('/items', [ItemController::class, 'index']); // بدون middleware لعرض المنتجات العامة

// صفحة تسجيل الدخول (اختيارية)
Route::get('/login', function () {
    return 'صفحة تسجيل الدخول';
})->name('login');
