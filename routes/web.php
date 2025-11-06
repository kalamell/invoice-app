<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard - Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Shop Management
    Route::get('/shop/create', [ShopController::class, 'create'])->name('shop.create');
    Route::post('/shop', [ShopController::class, 'store'])->name('shop.store');
    Route::get('/shop/edit', [ShopController::class, 'edit'])->name('shop.edit');
    Route::patch('/shop', [ShopController::class, 'update'])->name('shop.update');
    Route::get('/shop/settings', [ShopController::class, 'settings'])->name('shop.settings');
    Route::patch('/shop/settings', [ShopController::class, 'updateSettings'])->name('shop.settings.update');

    // Customer Management
    Route::resource('customers', CustomerController::class);

    // Document Management
    Route::resource('quotations', QuotationController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('receipts', ReceiptController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
