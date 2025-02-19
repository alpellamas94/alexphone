<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PhoneController extends Controller
{
    public function getAll($unify = false){
        
        // Pedimos los datos sin verificar SSL
        $response = Http::withoutVerifying()->get('https://test.alexphone.com/api/v1/skus');

        // Verificamos si la respuesta fue exitosa
        if ($response->successful()) {

            // Convertimos la respuesta en un objeto
            $objectPhones = json_decode($response->body());

            if($unify){
                $result = $this->unifyData($objectPhones);

                return $result;
            }
            
            return $objectPhones;
        } else {
            return null;
        }
    }

    private function unifyData($elements) {
        // Creamos un arreglo para agrupar los productos por nombre
        $unifiedElements = [];

        foreach ($elements as $phone) {
            // Si ya existe un elemento con este "name", combinamos las propiedades
            if (isset($unifiedElements[$phone->name])) {

                // Verificamos si el color ya existe antes de agregarlo
                if (!in_array($phone->color, $unifiedElements[$phone->name]->color)) {
                    $unifiedElements[$phone->name]->color = array_merge($unifiedElements[$phone->name]->color, [$phone->color]);
                }

                // Unimos los storage y los ordenamos de menor a mayor
                $unifiedElements[$phone->name]->storage = array_merge($unifiedElements[$phone->name]->storage, [$phone->storage]);
                sort($unifiedElements[$phone->name]->storage);

                // Verificamos si el grade ya existe antes de agregarlo
                if (!in_array($phone->grade, $unifiedElements[$phone->name]->grade)) {
                    $unifiedElements[$phone->name]->grade = array_merge($unifiedElements[$phone->name]->grade, [$phone->grade]);
                }

                // Mantenemos el precio más bajo
                if ($phone->price < $unifiedElements[$phone->name]->price) {
                    $unifiedElements[$phone->name]->price = $phone->price;
                }

            } else {
                // Si no existe el grupo, lo creamos con los colores, storage y grade como arrays
                $phone->color = [$phone->color];
                $phone->storage = [$phone->storage];
                $phone->grade = [$phone->grade];
                $unifiedElements[$phone->name] = $phone;
            }
        }
        
        return $unifiedElements;
    }

    public function getFilters($elements) {
        $filters = [
            'color' => [],
            'storage' => [],
            'grade' => []
        ];
    
        foreach ($elements as $phone) {
            $filters['color'] = array_merge($filters['color'], $phone->color);
            $filters['storage'] = array_merge($filters['storage'], $phone->storage);
            $filters['grade'] = array_merge($filters['grade'], $phone->grade);
        }
    
        // Eliminamos duplicados
        $filters['color'] = array_unique($filters['color']);
        $filters['storage'] = array_unique($filters['storage']);
        $filters['grade'] = array_unique($filters['grade']);
    
        return $filters;
    }
    
}
