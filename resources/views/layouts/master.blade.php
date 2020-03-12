<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') | {{ config('app.name', 'WWF Kenya') }}
        @else
            {{ config('app.name', 'WWF Kenya') }}
        @endif
    </title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <!-- Styles -->
    @stack('before-css')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @stack('after-css')
</head>
<body class="bg-gray-100 antialiased leading-none">
<div id="app">
    @yield('master-content')
</div>

<!-- Scripts -->
@stack('before-js')
<script src="{{ mix('js/app.js') }}"></script>
@stack('after-js')
</body>
</html>
