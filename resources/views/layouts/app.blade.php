<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/cinlei.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/components/app.jsx'])

</head>
<body class="min-h-screen flex flex-col 
    [background-image:radial-gradient(circle,_rgba(0,0,0,0.05)_1px,_transparent_1px),_linear-gradient(to_bottom_right,_#f3e8ff,_#fce7f3,_#dbeafe)] 
    [background-size:20px_20px,_cover]">
    
    @include('layouts.navbar')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('layouts.footer')

    @stack('scripts')
</body>
</html>
