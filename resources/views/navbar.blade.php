<div class="mdl-header">
    <a href="{{ route('home') }}" target="_self" class="m-logo">
        <img src="{{ asset('resources/imgs/alexphone.svg') }}" alt="Logo alexphone">
    </a>

    <a href="#" target="_self" id="m-cart" class="m-cart">
        <img src="{{ asset('resources/icons/cart.svg') }}" alt="Cart">
        
        @if(session()->has('cart'))
            <span>{{ $cartTotal }}</span>
        @endif
    </a>
</div>