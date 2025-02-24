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

test('getBySku returns valid Sku objects when API is successful', function () {
    // Llamamos al controlador directamente sin mockear la API
    $controller = new \App\Http\Controllers\PhoneController();
    $response = $controller->getBySku('iphone-12-pro-very-good-white-128');

    // Verifica que la respuesta no sea nula
    expect($response)->not->toBeNull();

    // Verifica la estructura del objeto devuelto
    expect($response)->toHaveProperties([
        'id',
        'sku',
        'name',
        'description',
        'price',
        'grade',
        'color',
        'storage',
        'image',
    ]);

    // Verifica los tipos de datos
    expect($response->id)->toBeString();
    expect($response->sku)->toBeString();
    expect($response->name)->toBeString();
    expect($response->description)->toBeString();
    expect($response->price)->toBeNumeric();
    expect($response->grade)->toBeIn(['excellent', 'very_good', 'good']);
    expect($response->color)->toBeIn(['white', 'black', 'red', 'pink']);
    expect($response->storage)->toBeIn([64, 128, 256, 512]);
    expect($response->image)->toBeString();
});

test('getFilters returns valid filters from a list of phones', function () {
    
    // Llamamos al controlador directamente
    $controller = new \App\Http\Controllers\PhoneController();
    $phones = $controller->getAll();
    $filters = $controller->getFilters($phones);

    // Verifica que la respuesta no sea nula
    expect($filters)->not->toBeNull();

    // Verifica la estructura del objeto devuelto
    expect($filters)->toHaveKeys(['name', 'color', 'storage', 'grade']);

    // Verifica los valores de los filtros
    expect($filters['name'])->toBeArray();
    foreach ($filters['name'] as $name) {
        expect($name)->toBeString();
    }
    
    expect($filters['grade'])->toBeArray();
    foreach ($filters['grade'] as $grade) {
        expect($grade)->toBeIn(['excellent', 'very_good', 'good']);
    }

    expect($filters['color'])->toBeArray();
    foreach ($filters['color'] as $color) {
        expect($color)->toBeIn(['white', 'black', 'red', 'pink']);
    }

    expect($filters['storage'])->toBeArray();
    foreach ($filters['storage'] as $storage) {
        expect($storage)->toBeIn([64, 128, 256, 512]);
    }
});