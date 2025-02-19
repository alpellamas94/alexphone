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
            Bienvenid@ a mi prueba técnica para Alexphone
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
                    <div class="m-select">
                        <select id="grade-filter">
                            <option value="">Todos los estados</option>
                            @foreach ($filters['grade'] as $g)
                                <option value=".{{$g}}">{{config('grades.' . $g)}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="m-select">
                        <select id="color-filter">
                            <option value="">Todos los colores</option>
                            @foreach ($filters['color'] as $c)
                                <option value=".{{$c}}">{{config('colors.' . $c)}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="m-select">
                        <select id="storage-filter">
                            <option value="">Todos las capacidades</option>
                            @foreach ($filters['storage'] as $s)
                                <option value=".storage-{{$s}}">{{$s}} GB</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div id="grid-elements" class="m-grid">
                @foreach ($elements as $key => $item)
                    <div class="m-item mix {{ $item->color }} {{ $item->grade }} storage-{{ $item->storage }}">
                        <div class="m-img" style="background-image: url('{{$item->image}}');"></div>
                        <div class="m-info">
                            <div class="m-title">{{$item->name}}</div>
                            <div class="m-desc">{{$item->description}}</div>
                            <div class="m-features">
                                <div class="m-colors">
                                    <span class="m-color" style="background-color: {{$item->color}};"></span>
                                </div>

                                <div class="m-grade">
                                    <span>{{config('grades.' . $item->grade)}}</span>
                                </div>

                                <span class="m-storage">
                                    <span>{{$item->storage}} GB</span>
                                </span>
                                
                            </div>
                            <div class="m-price">
                                <span>Desde:</span>
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
            <div class="m-title">No se han encontrado elementos disponibles.</div>
        </div>
    @endif
@endsection