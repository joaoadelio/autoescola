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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    @yield('script')
</body>
</html>
