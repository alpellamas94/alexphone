<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PhoneController;

class FrontController extends Controller
{
    public function homepage(){
        
        $phoneController = new PhoneController();
        
        // Recuperamos los elementos
        $allElements = $phoneController->getAll();
        $elements = $phoneController->unifyData($allElements);

        $title = 'Homepage';

        return view('homepage', [
			'title' => $title,
			'elements' => $elements,
		]);
    }
}
