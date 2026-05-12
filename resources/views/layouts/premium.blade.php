@php
    $autoOpenModal = session()->pull('open_login_modal', false);
    $isArabic      = session('lang', 'ar') === 'ar';
    $isLoggedIn    = session()->has('participant_id');
@endphp
<!DOCTYPE html>
<html lang="{{ session('lang', 'ar') }}" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $isArabic ? 'رونق - ريم السعوي' : 'Rawnaq - Reem Al-Suwaie')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Aref+Ruqaa:wght@400;700&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="@yield('body-class', 'inner-page-bg') antialiased min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Header -->
    <header class="sticky top-0 z-40 bg-morris-cream/95 backdrop-blur-md border-b border-morris-border shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 sm:h-24">

                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex flex-col items-center justify-center group relative">
                    <svg class="w-6 h-6 text-morris-gold mb-[-8px] opacity-70 group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.5,2C15.5,2 13.5,3 12,4.5C10.5,3 8.5,2 6.5,2C2.5,2 0,5.5 0,9.5C0,15 12,22 12,22C12,22 24,15 24,9.5C24,5.5 21.5,2 17.5,2Z" opacity="0.3"/>
                        <path d="M12,22S0,15 0,9.5C0,5.5 2.5,2 6.5,2C8.5,2 10.5,3 12,4.5C13.5,3 15.5,2 17.5,2C21.5,2 24,5.5 24,9.5C24,15 12,22 12,22ZM12,19.2C14.7,17.2 22,12.2 22,9.5C22,6.6 20.1,4 17.5,4C15.4,4 13.6,5.4 12.8,7.3L12,9L11.2,7.3C10.4,5.4 8.6,4 6.5,4C3.9,4 2,6.6 2,9.5C2,12.2 9.3,17.2 12,19.2Z"/>
                    </svg>
                    <span class="font-brand text-3xl sm:text-4xl font-bold text-morris-primary tracking-wide">رونق</span>
                    <span class="font-magic text-lg sm:text-xl text-morris-terracotta mt-[-4px]">ريم السعوي</span>
                </a>

                <!-- Header Middle: Breadcrumbs -->
                @if(View::hasSection('header-middle'))
                    @yield('header-middle')
                @elseif(isset($pageTitle))
                    <div class="hidden md:flex items-center gap-2 text-sm font-semibold text-morris-text/60">
                        <a href="{{ route('home') }}" class="hover:text-morris-terracotta transition">الرئيسية</a>
                        <span>/</span>
                        <span class="text-morris-primary">{{ $pageTitle }}</span>
                    </div>
                @endif

                <!-- Header Actions -->
                @if(View::hasSection('header-actions'))
                    @yield('header-actions')
                @elseif(isset($backRoute))
                    <a href="{{ $backRoute }}" class="flex items-center gap-2 bg-morris-cream border border-morris-primary text-morris-primary hover:bg-morris-primary hover:text-white px-4 py-2 rounded-full transition-colors duration-300 shadow-sm text-sm sm:text-base font-semibold">
                        <span>العودة</span>
                        <svg class="w-4 h-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </a>
                @else
                    <div class="flex items-center gap-4">
                        <div class="hidden sm:flex bg-white rounded-full p-1 border border-morris-border shadow-sm">
                            <button class="px-3 py-1 rounded-full text-sm font-semibold bg-morris-primary text-white transition">AR</button>
                            <button class="px-3 py-1 rounded-full text-sm font-semibold text-morris-text hover:bg-morris-cream transition">EN</button>
                        </div>

                        @if($isLoggedIn)
                            <span class="hidden sm:inline-flex items-center text-sm text-morris-text font-semibold bg-white px-4 py-2 rounded-full border border-morris-border shadow-sm">
                                {{ session('participant_name') }}
                            </span>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 bg-morris-terracotta hover:bg-morris-primary text-white px-5 py-2.5 rounded-full transition-colors duration-300 shadow-sm text-sm sm:text-base font-semibold">
                                    <span>{{ $isArabic ? 'خروج' : 'Logout' }}</span>
                                </button>
                            </form>
                        @else
                            <button id="header-login-btn" data-open-login-modal class="flex items-center gap-2 bg-morris-terracotta hover:bg-morris-primary text-white px-5 py-2.5 rounded-full transition-colors duration-300 shadow-sm text-sm sm:text-base font-semibold">
                                <span>دخول</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            </button>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-sm border-t border-morris-border mt-auto">
        <div class="container mx-auto px-4 py-8 text-center">
            <p class="text-morris-text/60 text-sm font-semibold">
                &copy; {{ date('Y') }} رونق - ريم السعوي. جميع الحقوق محفوظة.
            </p>
        </div>
    </footer>

    <!-- Login Modal & JS Logic -->
    @include('components.premium-login-modal')

    @stack('scripts')
</body>
</html>
