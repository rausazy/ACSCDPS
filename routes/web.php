<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

// Protektadong pages → kailangan naka-login lahat kasama ang home
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home'); 
    });

    Route::get('/products', function () {
        return view('products'); 
    });

    Route::get('/services', function () {
        return view('services'); 
    });

    Route::get('/profile', function () {
        return view('profile'); 
    });

    Route::get('/stocks', function () {
        return view('stocks'); 
    });
});

// Login / Register routes → accessible kahit logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [LoginController::class, 'register'])->name('register');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



