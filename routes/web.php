<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StocksController;

// ----- GUEST ROUTES -----
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
});

// ----- AUTH ROUTES -----
Route::middleware('auth')->group(function () {

    // Home / Dashboard
    Route::get('/', function () {
        return view('home');
    })->name('home');

    // Profile
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    // Stocks
    Route::get('/stocks', [StocksController::class, 'index'])->name('stocks.stocks');
    Route::get('/stocks/{stock}', [StocksController::class, 'show'])->name('stocks.show');
    Route::post('/stocks', [StocksController::class, 'store'])->name('stocks.store');
    Route::put('/stocks/{stock}', [StocksController::class, 'update'])->name('stocks.update');

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
});
