<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PhoneController extends Controller
{
    public static function getPhones(){
        
        // Pedimos los datos
        $response = Http::get('https://test.alexphone.com/api/v1/skus');

        // Verificamos si la respuesta fue exitosa
        if ($response->successful()) {

            // Convertimos la respuesta en un array
            $phonesArray = $response->json();

            return $phonesArray;
        } else {
            return null;
        }
    }
}
