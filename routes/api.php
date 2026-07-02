<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\ImportExportController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Category Routes
Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('products', ProductController::class);
Route::get('/categories/export', [CategoryController::class, 'export']);
Route::post('/categories/import', [CategoryController::class, 'import']);
Route::apiResource('categories', CategoryController::class);
Route::get('/import-export/{resource}/export', [ImportExportController::class, 'export']);
Route::post('/import-export/{resource}/import', [ImportExportController::class, 'import']);