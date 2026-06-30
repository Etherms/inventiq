<?php

use App\Http\Controllers\Auth\SessionAuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => Inertia::render('Auth/Login'))->name('login');
    Route::get('/register', fn () => Inertia::render('Auth/Register'))->name('register');

    Route::post('/login', [SessionAuthController::class, 'login'])->name('login.store');
    Route::post('/register', [SessionAuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/categories', fn () => Inertia::render('Categories'))->name('categories');
    Route::get('/suppliers', fn () => Inertia::render('Suppliers'))->name('suppliers');
    Route::get('/products', fn () => Inertia::render('Products'))->name('products');
    Route::get('/stock-movement', fn () => Inertia::render('StockMovement'))->name('stock-movement');

    Route::post('/logout', [SessionAuthController::class, 'logout'])->name('logout');
});