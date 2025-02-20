<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CartController;

// Ruta a la página principal
Route::get('/',[FrontController::class,'homepage'])->name('home');

// Ruta al detalle de producto
Route::get('/product/{sku}', [FrontController::class,'product'])->name('product.detail');

// Añadir al cart elemento
Route::post('/add-cart', [CartController::class, 'add'])->name('cart.add');
