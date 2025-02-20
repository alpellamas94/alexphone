<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        // Obtenemos el Sku del producto
        $sku = $request->input('sku');

        // Verificar si existe la sesión 'cart', si no, crearla como un array vacío
        $cart = session()->get('cart', []);

        // Verificar si el producto ya está en el cart
        if (array_key_exists($sku, $cart)) {
            $cart[$sku]++;
        } else {
            $cart[$sku] = 1;
        }

        // Guardar el cart actualizado en la sesión
        session()->put('cart', $cart);

        return response()->json([
            'mensaje' => 'El producto ha sido añadido al carrito exitosamente.',
            'cart' => $cart
        ]);
    }
    
    public static function getTotal()
    {
        // Recuperamos el cart de la sesión
        $cart = session()->get('cart', []);

        // Contamos el número de elementos en el cart
        $count = array_sum(array_map('intval', $cart));

        return $count;
    }

    public function getCart()
    {
        // Obtenemos el array de elementos de la sesión
        $cart = session()->get('cart', []);

        return $cart;
    }
}
