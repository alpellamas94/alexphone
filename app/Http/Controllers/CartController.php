<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\PhoneController;

interface CreateOrderSku {
    public function getId(): string;
    public function getSku(): string;
    public function getGrade(): string;
    public function getColor(): string;
    public function getStorage(): int;
}

interface CreateOrderBody {
    /** @return Sku[] */
    public function getSkus(): array;
}

interface Sku {
    public function getId(): string;
    public function getSku(): string;
    public function getName(): string;
    public function getDescription(): string;
    public function getPrice(): float;
    public function getGrade(): string;
    public function getColor(): string;
    public function getStorage(): int;
    public function getImage(): string;
}

interface SkuConstants {
    public const SKU_GRADES = ['excellent', 'very_good', 'good'];
    public const SKU_COLORS = ['white', 'black', 'red', 'pink'];
    public const SKU_STORAGES = [64, 128, 256, 512];
}

class CartController extends Controller
{
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

    public function payCart()
    {
        // Recuperamos el array del carrito
        $cart = $this->getCarrito();

        // Crear el array de SKUs
        $skus = array_reduce($cart, function ($arrayClean, $item) {
            for ($i = 0; $i < $item->quantity; $i++) {
                $arrayClean[] = new class($item) implements CreateOrderSku {
                    private $item;

                    public function __construct($item)
                    {
                        // Solo asignar los campos requeridos
                        $this->item = (object) [
                            'id' => $item->id,
                            'sku' => $item->sku,
                            'grade' => $item->grade,
                            'color' => $item->color,
                            'storage' => $item->storage,
                        ];
                    }

                    public function getId(): string { return $this->item->id; }
                    public function getSku(): string { return $this->item->sku; }
                    public function getGrade(): string { return $this->item->grade; }
                    public function getColor(): string { return $this->item->color; }
                    public function getStorage(): int { return $this->item->storage; }
                };
            }
            return $arrayClean;
        }, []);

        // Validar los SKUs antes de enviar
        foreach ($skus as $sku) {
            if (!in_array($sku->getGrade(), SkuConstants::SKU_GRADES)) {
                throw new \Exception("Invalid grade value: " . $sku->getGrade());
            }
            if (!in_array($sku->getColor(), SkuConstants::SKU_COLORS)) {
                throw new \Exception("Invalid color value: " . $sku->getColor());
            }
            if (!in_array($sku->getStorage(), SkuConstants::SKU_STORAGES)) {
                throw new \Exception("Invalid storage value: " . $sku->getStorage());
            }
        }

        // Crear el cuerpo de la solicitud
        $orderBody = new class($skus) implements CreateOrderBody {
            private array $skus;

            public function __construct(array $skus)
            {
                $this->skus = $skus;
            }

            public function getSkus(): array
            {
                return $this->skus;
            }
        };

        // Transformar los objetos CreateOrderSku en arrays asociativos
        $skusData = array_map(function ($sku) {
            return [
                'id' => $sku->getId(),
                'sku' => $sku->getSku(),
                'grade' => $sku->getGrade(),
                'color' => $sku->getColor(),
                'storage' => $sku->getStorage(),
            ];
        }, $orderBody->getSkus());

        // Realizamos el PUT
        $response = Http::put('https://test.alexphone.com/api/v1/order', [
            'skus' => $skusData,
        ]);

        // Verificar la respuesta de la API
        if ($response->successful()) {
            // Limpiar el carrito de la sesión
            session()->forget('cart');

            return true;
        } else {
            // Manejar el error en caso de que la solicitud falle
            return response()->json([
                'mensaje' => 'Error al procesar el pago del carrito.',
                'error' => $response->body()
            ], $response->status());
        }
    }
}