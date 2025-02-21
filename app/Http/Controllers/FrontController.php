<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PhoneController;

class FrontController extends Controller
{
    protected $phoneController;

    public function __construct(PhoneController $phoneController)
    {
        $this->phoneController = $phoneController;
    }

    public function homepage()
    {
        // Recuperamos los elementos pasándole true en el primer parámetro para que devuelva los elementos unificados
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
}
