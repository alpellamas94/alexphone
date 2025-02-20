<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

// Ruta a la página principal
Route::get('/',[FrontController::class,'homepage']);

// Ruta al detalle de producto
Route::get('/product/{sku}', [FrontController::class,'product'])->name('product.detail');
