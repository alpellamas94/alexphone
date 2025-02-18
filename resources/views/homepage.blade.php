@extends('layout')

@section('title_page')
Home
@endsection

@section('navbar')
    @include('navbar')
@endsection

@section('content')
    <div class="mdl-hero">
        <div class="m-content">
            Bienvenid@ a mi prueba técnica Alexphone
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <img class="swiper-slide" src="https://picsum.photos/1920/700" alt="picsum1">
                <img class="swiper-slide" src="https://picsum.photos/1920/800" alt="picsum2">
                <img class="swiper-slide" src="https://picsum.photos/1920/900" alt="picsum3">
            </div>
        </div>
    </div>

    @if (isset($elements) && !is_null($elements))
        <div class="mdl-listado">
            <div class="m-title">Listado de teléfonos disponibles:</div>
    
            <div class="m-content">
                
                <div class="m-filters">
                    <select id="category-filter" class="m-filter">
                        <option value="">Todos los estados</option>
                        <option value=".excellent">excellent</option>
                        <option value=".very_good">very_good</option>
                        <option value=".good">good</option>
                    </select>
                    
                    <select id="color-filter" class="m-filter">
                        <option value="">Todos los colores</option>
                        <option value=".white">white</option>
                        <option value=".black">black</option>
                        <option value=".red">red</option>
                        <option value=".pink">pink</option>
                    </select>
    
                    <button data-sort="default:asc">Ordenar A-Z</button>
                    <button data-sort="default:desc">Ordenar Z-A</button>
                </div>
    
                <div id="grid-elements" class="m-grid">
                @foreach ($elements as $key => $item)
                    <div class="m-item mix {{$item->grade}} {{$item->color}}">
                        <div class="m-img" style="background-image: url('{{$item->image}}');"></div>
                        <div class="m-info">
                            <div class="m-title">{{$item->name}}</div>
                            <div class="m-desc">{{$item->description}}</div>
                            <div class="m-features">
                                <div class="m-grade">
                                    <span>{{$item->grade}} -&nbsp;</span>
                                    <span>{{$item->grade}}</span>
                                </div>
                                <div class="m-colors">
                                    <span class="m-color" style="background-color: {{$item->color}};"></span>
                                </div>
                                <span class="m-storage">{{$item->storage}}</span>
                            </div>
                            <div class="m-price">
                                <span>Precio:</span>
                                <strong>{{$item->price}}€</strong>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>    
    @else
        <div class="mdl-listado error">
            <div class="m-title">No hay teléfonos disponibles ahora mismo</div>
        </div>
    @endif
@endsection