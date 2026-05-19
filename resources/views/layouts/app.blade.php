<!DOCTYPE html>
<html lang="{{ session('lang', 'ar') }}" dir="{{ session('lang', 'ar') === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ rtrim(url('/'), '/') }}">
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
        
        @unless(request()->routeIs('design-tool'))
        <footer class="bg-gray-900 text-gray-400 text-sm py-8 border-t border-gray-800 mt-auto">
            <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex gap-4">
                    <a href="{{ route('expert.survey') }}" class="hover:text-green-500 transition-colors">استمارة لجنة التحكيم</a>
                    <span>|</span>
                    <a href="{{ route('designer.survey') }}" class="hover:text-green-500 transition-colors">استمارة المصممين</a>
                </div>
                <div class="text-center md:text-left">
                    &copy; {{ date('Y') }} جامعة القصيم - تطبيق رونق.
                </div>
            </div>
        </footer>
        @endunless
    </div>

    @stack('scripts')
</body>
</html>
