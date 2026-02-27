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
        Route::get('/add', 'showCreate')->name('createProduct');
        Route::post('/add', 'create')->name('storeProduct');
        Route::get('/{productId}/edit', 'updateProduct')->name('editProduct');
        Route::match(['put', 'post'], '/{productId}', 'updateProduct')->name('updateProducts');
        Route::get('/{productId}', 'searchProduct');
        Route::delete('/{productId}', 'deleteProduct')->name('deleteProduct');
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

use App\Http\Controllers\Creator\AnalyticsController;
use App\Http\Controllers\Creator\SalesController;
use App\Http\Controllers\ProfileController;

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/sales', [SalesController::class, 'index'])->name('sales');
    Route::get('/settings', [ProfileController::class, 'index'])->name('settings');
    Route::post('/settings', [ProfileController::class, 'update'])->name('settings.update');
});



Route::get('/explorer', function (){
    return view('Products.explorer');
});


Route::get('/createurs', function (){
    return view('Products.createurs');
});

Route::get('/tarifs', function (){
    return view('Products.tarifs');
});
