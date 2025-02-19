<?php

test('getAll returns valid Sku objects when API is successful', function () {
    // Llamamos al controlador directamente sin mockear la API
    $controller = new \App\Http\Controllers\PhoneController();
    $phones = $controller->getAll();

    // Verificamos que la respuesta no sea nula
    expect($phones)->not->toBeNull()
        ->and($phones)->toBeArray()
        ->and(count($phones))->toBeGreaterThan(0);

    // Verificamos que cada elemento cumpla con la estructura de Sku
    foreach ($phones as $phone) {
        expect($phone)->toHaveKeys(['id', 'sku', 'name', 'description', 'price', 'grade', 'color', 'storage', 'image'])
            ->and($phone->id)->toBeString()
            ->and($phone->sku)->toBeString()
            ->and($phone->name)->toBeString()
            ->and($phone->description)->toBeString()
            ->and($phone->price)->toBeNumeric()
            ->and($phone->grade)->toBeIn(['excellent', 'very_good', 'good'])
            ->and($phone->color)->toBeIn(['white', 'black', 'red', 'pink'])
            ->and($phone->storage)->toBeIn([64, 128, 256, 512])
            ->and($phone->image)->toBeString();
    }
});

test('getAll returns null when API fails', function () {
    // Mock de una respuesta fallida
    Http::fake([
        'https://test.alexphone.com/api/v1/skus' => Http::response(null, 500)
    ]);

    $controller = new \App\Http\Controllers\PhoneController();
    $phones = $controller->getAll();

    expect($phones)->toBeNull();
});
