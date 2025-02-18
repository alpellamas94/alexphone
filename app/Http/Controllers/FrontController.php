<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PhoneController;

class FrontController extends Controller
{
    public function homepage(){
        
        $phoneController = new PhoneController();
        
        // Recuperamos los elementos pasandole true en el primer parámetro para que devuelva los elementos unificados
        $elements = $phoneController->getAll(true);

        // Sacamos los filtros en base a los elementos
        $filters = $phoneController->getFilters($elements);

        // AÑadimos el título de la página
        $title = 'Homepage';

        return view('homepage', [
			'title' => $title,
			'elements' => $elements,
			'filters' => $filters,
		]);
    }
}
