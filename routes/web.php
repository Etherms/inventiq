<?php

use App\Http\Controllers\Auth\SessionAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StockMovementController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\NewPasswordController;

use Inertia\Inertia;

Route::get('/', fn () => redirect()->route('login'));
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => Inertia::render('Auth/Auth'))->name('login');
    Route::get('/register', fn () => Inertia::render('Auth/Auth', [
        'mode' => 'register',
    ]))->name('register');

    Route::post('/login', [SessionAuthController::class, 'login']);
    Route::post('/register', [SessionAuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/categories', fn () => Inertia::render('Categories'))->name('categories');
    Route::get('/suppliers', fn () => Inertia::render('Suppliers'))->name('suppliers');
    Route::get('/products', fn () => Inertia::render('Products'))->name('products');
    Route::get('/stock-movement', fn () => Inertia::render('StockMovement'))->name('stock-movement');

    Route::post('/logout', [SessionAuthController::class, 'logout'])->name('logout');
    Route::get('/stock-movements/list', [StockMovementController::class, 'index']);
    Route::post('/stock-in', [StockMovementController::class, 'stockIn']);
    Route::post('/stock-out', [StockMovementController::class, 'stockOut']);
    Route::get('/products/{product}/history', [StockMovementController::class, 'history']);

    Route::get('/stock-movements/statistics', [StockMovementController::class, 'statistics']);
    Route::get('/stock-movements/list', [StockMovementController::class, 'index']);
    Route::get('/stock-movements/export', [StockMovementController::class, 'export']);
    Route::post('/stock-movements/import', [StockMovementController::class, 'import']);
    Route::get('/stock-movements/statistics', [StockMovementController::class, 'statistics']);

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{user}/send-password-reset', [UserController::class, 'sendPasswordReset'])
        ->name('users.send-password-reset');
});