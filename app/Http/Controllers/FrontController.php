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

        // Sacamos los filtros en base a los elementos
        $filters = $phoneController->getFilters($elements);

        // Añadimos el título de la página
        $title = 'Homepage';

        return view('homepage', [
			'title' => $title,
			'elements' => $elements,
			'filters' => $filters,
		]);
    }
}
