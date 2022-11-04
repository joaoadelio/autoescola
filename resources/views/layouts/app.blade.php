<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.head')
</head>
<body>
    <div class="container" id="app">
        @if(Auth::check())
            @include('layout.nav')
        @endif

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
