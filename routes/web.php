<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CostingController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function () {
    // Home
    Route::get('/', fn () => view('home'))->name('home');
    Route::get('/profile', fn () => view('profile'))->name('profile');

    // Stocks
    Route::get('/stocks', [StocksController::class, 'index'])->name('stocks.stocks');
    Route::get('/stocks/{stock}', [StocksController::class, 'show'])->name('stocks.show');
    Route::post('/stocks', [StocksController::class, 'store'])->name('stocks.store');
    Route::put('/stocks/{stock}', [StocksController::class, 'update'])->name('stocks.update');

    // ✅ Raw Materials (nested sa Stock)
    Route::post('/stocks/{stock}/raw-materials', [RawMaterialController::class, 'store'])->name('raw-materials.store');
    Route::put('/raw-materials/{rawMaterial}', [RawMaterialController::class, 'update'])->name('raw-materials.update');
    Route::delete('/raw-materials/{rawMaterial}', [RawMaterialController::class, 'destroy'])->name('raw-materials.destroy');

    // Products
    Route::get('/products', [ProductsController::class, 'index'])->name('products.products');
    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{url}', [ProductsController::class, 'show'])->name('products.show');

    // Services
    Route::get('/services', [ServiceController::class, 'index'])->name('services.services');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::get('/services/{url}', [ServiceController::class, 'show'])->name('services.show');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/costing/{product}', [CostingController::class, 'show'])->name('costing.show');
    Route::post('/costing/{product}', [CostingController::class, 'store'])->name('costing.store');

    Route::post('/products/{product}/costing/pdf', [ProductsController::class, 'exportPdf'])
    ->name('products.costing-pdf');
});
