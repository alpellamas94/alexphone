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

    public function unifyData($phones) {
        // Creamos un arreglo para agrupar los productos por nombre
        $unifiedPhones = [];

        foreach ($phones as $phone) {
            // Si ya existe un grupo con este nombre, combinamos las propiedades
            if (isset($unifiedPhones[$phone->name])) {
                // Verificamos si el color ya existe antes de agregarlo
                if (!in_array($phone->color, $unifiedPhones[$phone->name]->color)) {
                    $unifiedPhones[$phone->name]->color = array_merge($unifiedPhones[$phone->name]->color, [$phone->color]);
                }
                // Unimos los storage
                $unifiedPhones[$phone->name]->storage = array_merge($unifiedPhones[$phone->name]->storage, [$phone->storage.' GB']);
            } else {
                // Si no existe el grupo, lo creamos con los colores y storage como arrays
                $phone->color = [$phone->color];
                $phone->storage = [$phone->storage. ' GB'];
                $unifiedPhones[$phone->name] = $phone;
            }
        }

        // Convertimos los arrays de color y storage en cadenas antes de retornar la respuesta
        foreach ($unifiedPhones as $key => $phone) {
            $phone->color = implode(' ', $phone->color);
            
            // Ordenamos los storage de menor a mayor
            usort($phone->storage, function($a, $b) {
                return intval($a) - intval($b);
            });
            $phone->storage = implode(' - ', $phone->storage);
        }
        
        return $unifiedPhones;
    }
}
