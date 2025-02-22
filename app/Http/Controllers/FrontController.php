<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\CartController;

class FrontController extends Controller
{
    protected $phoneController;
    protected $cartController;

    public function __construct(PhoneController $phoneController, CartController $cartController)
    {
        $this->phoneController = $phoneController;
        $this->cartController = $cartController;
    }

    public function homepage()
    {
        // Recuperamos los elementos de la llamada a la api
        $elements = $this->phoneController->getAll();

        // Sacamos los filtros en base a los elementos
        $filters = $elements ? $this->phoneController->getFilters($elements) : null;

        // Añadimos el título de la página
        $title_page = 'Página principal';

        return view('homepage', compact('title_page', 'elements', 'filters'));
    }

    public function product($sku)
    {
        // Recuperamos el producto concreto
        $element = $this->phoneController->getBySku($sku);

        $title_page = $element->name;

        return view('product', compact('title_page', 'element'));
    }

    public function cartlist()
    {
        // Recuperamos el array del carrito
        $cart = $this->cartController->getCarrito();

        $totalPrice = $this->cartController->getTotalPrice();

        // Añadimos el título de la página
        $title_page = 'Carrito';

        return view('cartlist', compact('title_page', 'cart', 'totalPrice'));
    }
}
