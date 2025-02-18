<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title_page')</title>

    <link rel="stylesheet" href="{{ asset('resources/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/swiper-bundle.min.css') }}">
    <script src="{{ asset('resources/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('resources/js/scripts.js') }}"></script>
    <script src="{{ asset('resources/js/fancybox.min.js') }}"></script>
    <script src="{{ asset('resources/js/swiper.min.js') }}"></script>
    <script src="{{ asset('resources/js/mixitup.min.js') }}"></script>
</head>
<body>
    @yield('navbar')
    
    @yield('content')
</body>
</html>