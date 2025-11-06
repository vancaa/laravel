<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

Route::prefix('products')->group(function () {
    Route::get('/lihat', [ProductController::class, 'lihat']);
    Route::get('/lihat/{id}', [ProductController::class, 'lihat_byid']);
});

Route::prefix('suppliers')->group(function () {
    Route::get('/lihat', [SupplierController::class, 'lihat']);
    Route::get('/lihat/{id}', [SupplierController::class, 'lihat_byid']);
});

Route::apiResource('users', UserController::class);

Route::get('test', function () {
    return response()->json(['message' => 'API is working!']);
});

