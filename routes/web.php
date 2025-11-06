<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPlanController;
use App\Http\Controllers\Admin\AdminShopController;
use App\Http\Controllers\Admin\AdminSubscriptionController;
use App\Http\Controllers\Admin\AdminUserController;
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

    // PDF Export Routes
    Route::get('/quotations/{quotation}/pdf', [QuotationController::class, 'exportPdf'])->name('quotations.pdf');
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'exportPdf'])->name('invoices.pdf');
    Route::get('/receipts/{receipt}/pdf', [ReceiptController::class, 'exportPdf'])->name('receipts.pdf');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Shops Management
    Route::get('/shops', [AdminShopController::class, 'index'])->name('shops.index');
    Route::get('/shops/{shop}', [AdminShopController::class, 'show'])->name('shops.show');
    Route::patch('/shops/{shop}/suspend', [AdminShopController::class, 'suspend'])->name('shops.suspend');
    Route::delete('/shops/{shop}', [AdminShopController::class, 'destroy'])->name('shops.destroy');

    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');

    // Subscriptions Management
    Route::get('/subscriptions', [AdminSubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/{subscription}', [AdminSubscriptionController::class, 'show'])->name('subscriptions.show');

    // Plans Management
    Route::resource('plans', AdminPlanController::class);
});

require __DIR__.'/auth.php';
