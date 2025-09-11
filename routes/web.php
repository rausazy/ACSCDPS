<?php

use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', function () {
    return view('home'); 
});

// Example static pages
Route::get('/products', function () {
    return view('products'); 
});

Route::get('/services', function () {
    return view('services'); 
});

Route::get('/profile', function () {
    return view('profile'); 
});

Route::get('/login', function () {
    return view('login'); 
});