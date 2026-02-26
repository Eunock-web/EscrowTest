<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Routes la manipulation des produits
Route::controller(ProductController::class)
    ->prefix('products')
    ->group(function () {
        Route::get('/', 'index')->name('allProduct');
        Route::post('/add', 'create')->name('createProduct');
        Route::get('/{productId}', 'SearchProduct');
        Route::delete('/{productId}', 'DeleteProduct');
        Route::put('/{productId}', 'updateProduct')->name('updateProducts');
    })->middleware('auth');

// Routes pour l'authentification
Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::get('/register', 'showRegister')->name('register');
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/register', 'register')->name('register.store');
        Route::post('/login', 'login')->name('login.store');
        Route::post('/logout', 'logout')->name('logout');
    });

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');



Route::get('/explorer', function (){
    return view('Products.explorer');
});

Route::get('/createurs', function (){
    return view('Products.createurs');
});

Route::get('/tarifs', function (){
    return view('Products.tarifs');
});
