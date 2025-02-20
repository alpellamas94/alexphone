<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PhoneController;

class FrontController extends Controller
{
    public function homepage(){
        $phoneController = new PhoneController();
        
        // Recuperamos los elementos pasándole true en el primer parámetro para que devuelva los elementos unificados
        $elements = $phoneController->getAll();

        // Comprobamos si elements trae resultados
        if (is_null($elements)) {
            // Sacamos los filtros en base a los elementos
            $filters = $phoneController->getFilters($elements);
        }else{
            $filters = null;
        }

        // Sacamos los filtros en base a los elementos
        $filters = $phoneController->getFilters($elements);

        // Añadimos el título de la página
        $title_page = 'Página principal';

        return view('homepage', [
			'title_page' => $title_page,
			'elements' => $elements,
			'filters' => $filters,
		]);
    }

    public function product($sku){
        $phoneController = new PhoneController();
        
        // Recuperamos los elementos pasándole true en el primer parámetro para que devuelva los elementos unificados
        $element = $phoneController->getBySku($sku);

        // Añadimos el título de la página
        $title_page = $element->name;

        return view('product', [
			'title_page' => $title_page,
			'element' => $element,
		]);
    }
}
