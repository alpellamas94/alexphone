<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\phoneController;

class CartController extends Controller
{
    protected $phoneController;

    public function __construct(PhoneController $phoneController)
    {
        $this->phoneController = $phoneController;
    }

    public function addcart(Request $request)
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

        return true;
    }

    public function remove(Request $request)
    {
        // Obtenemos el Sku del producto
        $sku = $request->input('sku');

        // Recuperamos el cart de la sesión
        $cart = session()->get('cart', []);

        // Verificamos si el producto existe en el cart
        if (array_key_exists($sku, $cart)) {
            // Eliminamos el producto del cart
            unset($cart[$sku]);

            // Guardamos el cart actualizado en la sesión
            session()->put('cart', $cart);

            return response()->json([
                'mensaje' => 'El producto ha sido eliminado del carrito.',
                'cart' => $cart
            ]);
        } else {
            return response()->json([
                'mensaje' => 'El producto no existe en el carrito.',
                'cart' => $cart
            ], 404);
        }
    }

    public function updateQuantity(Request $request)
    {
        // Obtenemos el Sku del producto y la nueva cantidad
        $sku = $request->input('sku');
        $quantity = $request->input('quantity');

        // Recuperamos el cart de la sesión
        $cart = session()->get('cart', []);

        // Verificamos si el producto existe en el cart
        if (array_key_exists($sku, $cart)) {
            // Actualizamos la cantidad del producto
            $cart[$sku] = $quantity;

            // Guardamos el cart actualizado en la sesión
            session()->put('cart', $cart);

            return response()->json([
                'mensaje' => 'La cantidad del producto ha sido actualizada exitosamente.',
                'cart' => $cart
            ]);
        } else {
            return response()->json([
                'mensaje' => 'El producto no existe en el carrito.',
                'cart' => $cart
            ], 404);
        }
    }
    
    public static function getSessionCount()
    {
        // Recuperamos el cart de la sesión
        $cart = session()->get('cart', []);

        // Contamos el número de elementos en el cart
        $count = array_sum(array_map('intval', $cart));

        return $count;
    }

    public function getSessionCart()
    {
        // Obtenemos el array de elementos de la sesión
        $cart = session()->get('cart', []);

        return $cart;
    }

    public function getCarrito()
    {
        // Recuperamos los elementos de la session
        $elementsSession = $this->getSessionCart();
        
        // Recuperamos los elementos de la api
        $elementsApi = $this->phoneController->getAll();

        $cart = [];

        foreach ($elementsSession as $sku => $quantity) {
            foreach ($elementsApi as $element) {
                if ($element->sku === $sku) {
                    $element->quantity = $quantity;
                    $cart[] = $element;
                    break;
                }
            }
        }

        return $cart;
    }

    public function getTotalPrice()
    {
        // Recuperamos los elementos del carrito
        $elements = $this->getCarrito();

        // Sumamos todos los precios de los elementos
        $totalPrice = 0;
        foreach ($elements as $element) {
            $totalPrice += $element->price * $element->quantity;
        }

        return $totalPrice;
    }
}