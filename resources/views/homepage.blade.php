@extends('layout')

@section('title_page')
{{$title_page}}
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
                <div class="swiper-slide" style="background-image: url('{{ asset('resources/imgs/slide1.jpg') }}')"></div>
                <div class="swiper-slide" style="background-image: url('{{ asset('resources/imgs/slide2.jpg') }}')"></div>
                <div class="swiper-slide" style="background-image: url('{{ asset('resources/imgs/slide3.jpg') }}')"></div>
                <div class="swiper-slide" style="background-image: url('{{ asset('resources/imgs/slide4.jpg') }}')"></div>
            </div>
        </div>
    </div>

    @if (isset($elements) && !is_null($elements))
        <div class="mdl-listado">
            <div class="m-title">Listado de iPhones disponibles</div>
    
            <div class="m-content">
                <div class="m-filters">

                    <div class="m-select">
                        <select id="sort-filter">
                            <option value="">Ordenar por</option>
                            <option value="price:asc">Precio: Menor a Mayor</option>
                            <option value="price:desc">Precio: Mayor a Menor</option>
                        </select>
                    </div>
                    
                    <div class="m-select">
                        <select id="name-filter">
                            <option value="">Todos los modelos</option>
                            @foreach ($filters['name'] as $n)
                                <option value=".{{ Str::slug($n) }}">{{$n}}</option>
                            @endforeach
                        </select>
                    </div>

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
                            <option value="">Todas las capacidades</option>
                            @foreach ($filters['storage'] as $s)
                                <option value=".storage-{{$s}}">{{$s}} GB</option>
                            @endforeach
                        </select>
                    </div>

                    <button id="reset-filter" class="m-reset">
                        <span>Eliminar filtros</span>
                        <img src="{{ asset('resources/icons/close.svg') }}" alt="Close">
                    </button>
                </div>
    
                <div id="grid-elements" class="m-grid">
                @foreach ($elements as $key => $item)
                    <a href="{{ route('product.detail', ['sku' => $item->sku]) }}" data-price="{{ $item->price }}" class="m-item mix {{ Str::slug($item->name) }} {{ $item->color }} {{ $item->grade }} storage-{{ $item->storage }}">
                        <div class="m-img" style="background-image: url('{{$item->image}}');"></div>
                        <div class="m-info">
                            <div class="m-title">{{$item->name}}</div>
                            <div class="m-desc">{{$item->description}}</div>
                            <div class="m-features m-row">
                                <div class="m-grade">
                                    <span>{{config('grades.' . $item->grade)}}</span>
                                </div>

                                <div class="m-storage">
                                    <span>{{$item->storage}} GB</span>
                                </div>

                                <div class="m-colors">
                                    <span class="m-color {{$item->color}}" style="background-color: {{$item->color}};">{{config('colors.' . $item->color)}}</span>
                                </div> 
                            </div>
                            <div class="m-price">
                                <span>Precio:</span>
                                <strong>{{ number_format($item->price, 0) }}€</strong>
                            </div>
                        </div>
                    </a>
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