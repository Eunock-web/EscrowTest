<?php

use App\Http\Controllers\Creator\AnalyticsController;
use App\Http\Controllers\Creator\SalesController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;

Route::get('/', function () {
    return view('welcome');
});

// Routes la manipulation des produits
Route::middleware(['auth', 'user.creator'])
    ->prefix('products')
    ->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('allProduct');
        Route::get('/add', [ProductController::class, 'showCreate'])->name('createProduct');
        Route::post('/add', [ProductController::class, 'create'])->name('storeProduct');
        Route::get('/{productId}/edit', [ProductController::class, 'updateProduct'])->name('editProduct');
        Route::match(['put', 'post'], '/{productId}', [ProductController::class, 'updateProduct'])->name('updateProducts');
        Route::get('/{productId}', [ProductController::class, 'searchProduct']);
        Route::delete('/{productId}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
    });

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
        

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware(['auth', 'user.creator']);

Route::middleware(['auth', 'user.creator'])->group(function () {
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/sales', [SalesController::class, 'index'])->name('sales');
});

Route::middleware('auth')->group(function () {
    Route::get('/settings', [ProfileController::class, 'index'])->name('settings');
    Route::post('/settings', [ProfileController::class, 'update'])->name('settings.update');
});

// Routes pour le client
Route::middleware(['auth', 'user.client'])->group(function () {
    Route::get('/mes-achats', [ClientController::class, 'purchases'])->name('client.purchases');
});

// Routes publiques / mixtes
Route::get('/explorer', [ClientController::class, 'index'])->name('explorer');
Route::get('/products/{id}', [ClientController::class, 'show'])->name('product.show');


Route::get('/createurs', [ClientController::class, 'creators'])->name('creators');

Route::get('/tarifs', function (){
    return view('Products.tarifs');
});

// Admin Authentication (Separate)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// Admin Protected Routes
Route::middleware(['auth', 'user.admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
});

//Routes pour le lancement du payementavec fedapay
