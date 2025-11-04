<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiPenjualanController;


Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('/products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('transaksi', TransaksiPenjualanController::class);
    Route::resource('categories', ProductCategoryController::class);
   Route::get('/send-email/{to}/{id}', [\App\Http\Controllers\transaksipenjualanController::class, 'sendEmail']);
});