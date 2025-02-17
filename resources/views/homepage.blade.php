@extends('layout')

@section('title_page')
Home
@endsection

@section('content')
    <div class="mdl-header show">
        <a href="https://www.alexphone.es/" target="_blank" class="m-logo">
            <img src="{{ asset('resources/imgs/alexphone.svg') }}" alt="Logo alexphone">
        </a>

        <a href="#" target="_self" class="m-carrito">
            <img src="{{ asset('resources/imgs/carrito.svg') }}" alt="Carrito">
            <span>2</span>
        </a>
    </div>

    <div class="mdl-hero"></div>
@endsection