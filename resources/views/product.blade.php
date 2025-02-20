@extends('layout')

@section('title_page')
{{$title_page}}
@endsection

@section('navbar')
    @include('navbar')
@endsection

@section('content')
    <div class="mdl-product">
        <div class="m-img" data-fancybox="{{$element->sku}}" src="{{$element->image}}">
            <img src="{{$element->image}}" alt="{{$element->sku}}">
        </div>

        <div class="m-section">
            <div class="m-title">{{$element->name}}</div>
            
            <div class="m-desc m-row">
                <strong>Descripción: </strong>
                <span>{{$element->description}}</span>
            </div>

            <div class="m-grade m-row">
                <strong>Estado: </strong>
                <span>{{config('grades.' . $element->grade)}}</span>
            </div>

            <div class="m-storage m-row">
                <strong>Capacidad: </strong>
                <span>{{$element->storage}} GB</span>
            </div>

            <div class="m-color m-row">
                <strong>Color: </strong>
                <span class="{{$element->color}}" style="background-color: {{$element->color}};">{{config('colors.' . $element->color)}}</span>
            </div>

            <div class="m-price m-row">
                <strong>Precio: </strong>
                <span>{{$element->price}}€</span>
            </div>

            <button id="m-add" data-sku="{{$element->sku}}" data-url="{{ route('cart.add') }}" data-token="{{ csrf_token() }}">
                <span>Añadir al carrito</span>
                <img src="{{ asset('resources/icons/plus.svg') }}" alt="add-cart">
            </button>
        </div>
    </div>

    <div id="message-cart">El producto ha sido añadido al carrito exitosamente.</div>
@endsection