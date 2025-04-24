<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionItemController;
use App\Http\Controllers\UnitController;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Purchase;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('units', [UnitController::class, 'index'])->name('units.index');
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactionItems', [TransactionItemController::class, 'index'])->name('transactionItems.index');
    Route::get('purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('purchaseItems', [PurchaseItemController::class, 'index'])->name('purchaseItems.index');
});

Route::middleware(['auth', RoleMiddleware::class . ":super_admin,sales_admin"])->group(function() {
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::get('transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::put('transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('transactions/{transaction}', [TransactionController::class, 'delete'])->name('transactions.destroy');
    Route::get('transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::post('transactionItems', [TransactionItemController::class, 'store'])->name('transactionItems.store');
    Route::get('transactionItems/create', [TransactionItemController::class, 'create'])->name('transactionItems.create');
    Route::get('transactionItems/{transactionItem}', [TransactionItemController::class, 'show'])->name('transactionItems.show');
    Route::put('transactionItems/{transactionItem}', [TransactionItemController::class, 'update'])->name('transactionItems.update');
    Route::delete('transactionItems/{transactionItem}', [TransactionItemController::class, 'destroy'])->name('transactionItems.destroy');
    Route::get('transactionItems/{transactionItem}/edit', [TransactionItemController::class, 'edit'])->name('transactionItems.edit');
    Route::put('/transactions/{transaction}/status/{status}', [TransactionController::class, 'setStatus'])->name('transactions.setStatus');
    Route::put('/transactions/{transaction}/customer', [TransactionController::class, 'setCustomer'])->name('transactions.setCustomer');
    Route::put('/transactions/{transaction}/detail/{transactionItem}', [TransactionItemController::class, 'update'])->name('transactionItems.updateDetail');
});

Route::middleware(['auth', RoleMiddleware::class . ':super_admin,purchases_admin'])->group(function() {
    Route::post('purchases', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::get('purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::put('purchases/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
    Route::delete('purchases/{purchase}', [PurchaseController::class, 'delete'])->name('purchases.destroy');
    Route::get('purchases/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
    Route::post('purchaseItems', [PurchaseItemController::class, 'store'])->name('purchaseItems.store');
    Route::get('purchaseItems/create', [PurchaseItemController::class, 'create'])->name('purchaseItems.create');
    Route::get('purchaseItems/{purchaseItem}', [PurchaseItemController::class, 'show'])->name('purchaseItems.show');
    Route::put('purchaseItems/{purchaseItem}', [PurchaseItemController::class, 'update'])->name('purchaseItems.update');
    Route::delete('purchaseItems/{purchaseItem}', [PurchaseItemController::class, 'delete'])->name('purchaseItems.destroy');
    Route::get('purchaseItems/{purchaseItem}/edit', [PurchaseItemController::class, 'edit'])->name('purchaseItems.edit');
    Route::put('/purchases/{purchase}/status/{status}', [PurchaseController::class, 'setStatus'])->name('purchases.setStatus');
    Route::put('/purchases/{purchase}/supplier', [PurchaseController::class, 'setSupplier'])->name('purchases.setSupplier');
    Route::put('/purchases/{purchase}/detail/{purchaseItem}', [PurchaseItemController::class, 'update'])->name('purchaseItems.updateDetail');
});

Route::middleware(['auth', RoleMiddleware::class . ':super_admin'])->group(function() {
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::patch('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'delete'])->name('categories.destroy');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'delete'])->name('products.destroy');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('units', [UnitController::class, 'store'])->name('units.store');
    Route::get('units/create', [UnitController::class, 'create'])->name('units.create');
    Route::get('units/{unit}', [UnitController::class, 'show'])->name('units.show');
    Route::put('units/{unit}', [UnitController::class, 'update'])->name('units.update');
    Route::delete('units/{unit}', [UnitController::class, 'delete'])->name('units.destroy');
    Route::get('units/{unit}/edit', [UnitController::class, 'edit'])->name('units.edit');
});