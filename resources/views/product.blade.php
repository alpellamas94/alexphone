@extends('layout')

@section('title_page')
{{$title_page}}
@endsection

@section('navbar')
    @include('navbar')
@endsection

@section('content')
    <div class="mdl-detail">
        <div class="m-img">
            <img src="{{$element->image}}" alt="{{$element->sku}}">
        </div>

        <div class="m-section">
            <div class="m-title">{{$element->name}}</div>
            
            <div class="m-desc m-col">
                <strong>Descripción</strong>
                <span>{{$element->description}}</span>
            </div>

            <div class="m-grade m-col">
                <strong>Estado</strong>
                <span>{{config('grades.' . $element->grade)}}</span>
            </div>

            <div class="m-storage m-col">
                <strong>Capacidad</strong>
                <span>{{$element->storage}} GB</span>
            </div>

            <div class="m-color m-col">
                <strong>Color</strong>
                <span class="{{$element->color}}" style="background-color: {{$element->color}};">{{config('colors.' . $element->color)}}</span>
            </div>

            <div class="m-price m-col">
                <strong>Precio</strong>
                <span>{{$element->price}}€</span>
            </div>

            {{-- <button class="m-add">Añadir al carrito</button> --}}
        </div>
    </div>
@endsection