<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('suppliers/search', SupplierController::class)->name('suppliers');

    Route::get('products/{id}', ProductController::class)->name('products');
});
