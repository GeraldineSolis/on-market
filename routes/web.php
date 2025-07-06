<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalogo', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/producto/{product}', [HomeController::class, 'show'])->name('product.show');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Rutas del carrito
Route::get('/carrito', [CartController::class, 'index'])->name('cart');
Route::post('/carrito/agregar/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/carrito/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrito/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

// Rutas de checkout
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/procesar-orden', [CartController::class, 'processOrder'])->name('order.process');
Route::get('/orden-exitosa/{order}', [CartController::class, 'orderSuccess'])->name('order.success');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    // ... otras rutas admin
});
// Rutas de administración
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin', [AdminController::class, 'dashboard'])->middleware('auth')->name('admin.dashboard');
    // Productos
    Route::get('/productos', [AdminController::class, 'products'])->name('products');
    Route::get('/productos/crear', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/productos', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/productos/{product}/editar', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::patch('/productos/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/productos/{product}', [AdminController::class, 'deleteProduct'])->name('products.delete');
    
    // Órdenes
    Route::get('/ordenes', [AdminController::class, 'orders'])->name('orders');
    Route::get('/ordenes/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/ordenes/{order}/estado', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
});

