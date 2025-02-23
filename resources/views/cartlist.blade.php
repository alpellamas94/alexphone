@extends('layout')

@section('title_page')
{{$title_page}}
@endsection

@section('navbar')
    @include('navbar')
@endsection

@section('content')
    <div class="mdl-cartlist" data-update="{{ route('cart.update.quantity') }}" data-delete="{{ route('cart.remove') }}" data-token="{{ csrf_token() }}">
        @if ($cart)
        <div class="m-grid">
            @foreach ($cart as $element)
                <div class="m-element" data-sku="{{$element->sku}}">
                    <a class="m-section" href="{{ route('product.detail', ['sku' => $element->sku]) }}" target="_blank">
                        <div class="m-img">
                            <img src="{{$element->image}}" alt="{{$element->sku}}">
                        </div>

                        <div class="m-info">
                            <div class="m-title"> {{$element->name}} - {{config('grades.' . $element->grade)}} - {{$element->storage}}GB - {{config('colors.' . $element->color)}} </div>

                            <div class="m-desc"> {{$element->description}} </div>

                            <div class="m-price"><span>Precio por unidad</span> {{number_format($element->price, 0) }}€ </div>
                        </div>
                    </a>
                    <div class="m-controls">
                        <div class="m-remove check-disabled">
                            <img src="{{ asset('resources/icons/remove.svg') }}" alt="less">
                        </div>

                        <div class="m-quantity">
                            <div class="m-less check-disabled">
                                <img src="{{ asset('resources/icons/less.svg') }}" alt="less">
                            </div>
                                <input type="number" readonly name="adultos" min="0" max="5" value="{{number_format($element->quantity)}}">
                            <div class="m-more check-disabled">
                                <img src="{{ asset('resources/icons/more.svg') }}" alt="more">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div id="m-total">
            <div class="m-title">Resumen</div>

            <div class="m-info">
                <span>Importe total:</span><strong> {{ number_format($totalPrice, 0) }}€</strong>
            </div>
            
            <button id="m-pay" class="m-button full check-disabled" data-url="{{ route('cart.pay') }}" onclick="payCart(this);">
                <span>Realizar pedido</span>
                <img src="{{ asset('resources/icons/cart.svg') }}" alt="buy-cart">
            </button>
        </div>
        @endif

        <div class="m-empty @if (!$cart) show @endif">
            <span>Todavía no has seleccionado ningún producto.</span>
            <a class="m-button" href="{{ route('home') }}">
                <span>Volver a la página principal</span>
            </a>
        </div>
    </div>

    <div id="message-cart"></div>
@endsection