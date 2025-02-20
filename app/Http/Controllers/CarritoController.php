<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function add(Request $request)
    {
        // Obtener el ID del producto desde la solicitud
        $productoId = $request->input('producto_id');

        // Verificar si existe la sesión 'carrito', si no, crearla como un array vacío
        $carrito = session()->get('carrito', []);

        // Agregar el producto al carrito si no está ya agregado
        if (!in_array($productoId, $carrito)) {
            $carrito[] = $productoId;
            session()->put('carrito', $carrito);
        }

        return response()->json([
            'mensaje' => 'Producto añadido al carrito',
            'carrito' => $carrito
        ]);
    }
}
