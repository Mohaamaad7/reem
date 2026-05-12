<!DOCTYPE html>
<html lang="{{ session('lang', 'ar') }}" dir="{{ session('lang', 'ar') === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#8b6914">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <title>@yield('title', 'Rawnaq') - {{ session('lang', 'ar') === 'ar' ? 'رونق' : 'Rawnaq' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Aref+Ruqaa:wght@400;700&family=Cairo:wght@300;400;600;700&family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/animations.css', 'resources/css/rtl.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="site-shell">
        @include('components.header')

        <main class="site-main @if(request()->routeIs('design-tool')) site-main--dt @endif">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
