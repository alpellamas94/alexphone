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

    <div class="mdl-hero">
        <div class="m-content">
            Bienvenid@ a Alexphone
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <img class="swiper-slide" src="https://picsum.photos/1920/700" alt="picsum1">
                <img class="swiper-slide" src="https://picsum.photos/1920/800" alt="picsum2">
                <img class="swiper-slide" src="https://picsum.photos/1920/900" alt="picsum3">
            </div>
        </div>
    </div>
@endsection