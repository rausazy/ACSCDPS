<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Cinlei Automated Costing') }}</title>
    <link rel="icon" href="{{ asset('images/cinlei.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    @include('layouts.navbar')

    <main class="p-6">
        @yield('content')
    </main>

    @include('layouts.footer')

    @stack('scripts')
</body>
</html>
