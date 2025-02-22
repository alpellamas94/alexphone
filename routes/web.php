<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CartController;

// Ruta a la página principal
Route::get('/',[FrontController::class,'homepage'])->name('home');

// Ruta al detalle de producto
Route::get('/product/{sku}', [FrontController::class,'product'])->name('product.detail');

// Ruta al listado del carrito
Route::get('/cart-list', [FrontController::class,'cartlist'])->name('cart.list');

// Añadir al cart elemento
Route::post('/add-cart', [CartController::class, 'add'])->name('cart.add');

// Actualizar la cantidad de un elemento de carrito
Route::post('/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');

// Eliminar un elemento de carrito
Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
