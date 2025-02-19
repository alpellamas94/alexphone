<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PhoneController extends Controller
{
    public function getAll(){
        
        // Pedimos los datos sin verificar SSL
        $response = Http::withoutVerifying()->get('https://test.alexphone.com/api/v1/skus');

        // Verificamos si la respuesta fue exitosa
        if ($response->successful()) {

            // Convertimos la respuesta en un objeto
            $objectPhones = json_decode($response->body());
            
            return $objectPhones;
        } else {
            return null;
        }
    }

    public function getFilters($elements) {
        $filters = [
            'color' => [],
            'storage' => [],
            'grade' => []
        ];
    
        foreach ($elements as $phone) {
            $filters['color'][] = $phone->color;
            $filters['storage'][] = $phone->storage;
            $filters['grade'][] = $phone->grade;
        }
    
        // Eliminamos duplicados
        $filters['color'] = array_unique($filters['color']);
        $filters['storage'] = array_unique($filters['storage']);
        $filters['grade'] = array_unique($filters['grade']);
    
        return $filters;
    }
    
}
