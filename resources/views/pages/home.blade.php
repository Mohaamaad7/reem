@php
$autoOpenModal = session()->pull('open_login_modal', false);
$isArabic      = session('lang', 'ar') === 'ar';
$isLoggedIn    = session()->has('participant_id');
@endphp
<!DOCTYPE html>
<html lang="{{ session('lang', 'ar') }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $isArabic ? 'رونق - ريم السعوي' : 'Rawnaq - Reem Al-Suwaie' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Aref+Ruqaa:wght@400;700&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="home-bg antialiased min-h-screen flex flex-col relative overflow-x-hidden">
<header class="sticky top-0 z-40 bg-morris-cream/90 backdrop-blur-md border-b border-morris-border shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-24">

            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center group relative">
                <svg class="w-6 h-6 text-morris-gold mb-[-8px] opacity-70 group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.5,2C15.5,2 13.5,3 12,4.5C10.5,3 8.5,2 6.5,2C2.5,2 0,5.5 0,9.5C0,15 12,22 12,22C12,22 24,15 24,9.5C24,5.5 21.5,2 17.5,2Z" opacity="0.3"/>
                    <path d="M12,22S0,15 0,9.5C0,5.5 2.5,2 6.5,2C8.5,2 10.5,3 12,4.5C13.5,3 15.5,2 17.5,2C21.5,2 24,5.5 24,9.5C24,15 12,22 12,22ZM12,19.2C14.7,17.2 22,12.2 22,9.5C22,6.6 20.1,4 17.5,4C15.4,4 13.6,5.4 12.8,7.3L12,9L11.2,7.3C10.4,5.4 8.6,4 6.5,4C3.9,4 2,6.6 2,9.5C2,12.2 9.3,17.2 12,19.2Z"/>
                </svg>
                <span class="font-brand text-4xl font-bold text-morris-primary tracking-wide">رونق</span>
                <span class="font-magic text-xl text-morris-terracotta mt-[-4px]">ريم السعوي</span>
            </a>

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
        </div>
    </div>
</header>
<main class="flex-grow">
    <section class="hero-section py-6 lg:py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <div class="relative rounded-[2rem] bg-morris-primary overflow-hidden shadow-2xl flex flex-col md:flex-row items-center justify-between border border-morris-primary/20">
                <div class="absolute inset-0 opacity-[0.04] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23F8F5F0\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                <div class="absolute inset-3 border border-morris-gold/20 rounded-[1.5rem] pointer-events-none hidden sm:block"></div>

                <div class="relative z-10 px-6 py-8 md:p-10 lg:p-16 md:w-3/5 text-right flex flex-col justify-center">
                    <div class="inline-flex items-center gap-3 mb-2 md:mb-4 fade-in-up" style="animation-delay: 0.1s;">
                        <span class="h-[2px] w-8 bg-morris-gold rounded-full"></span>
                        <span class="font-magic text-morris-gold text-xl">إلهام الطبيعة</span>
                    </div>
                    <h1 class="font-brand text-2xl sm:text-3xl lg:text-5xl text-morris-cream mb-2 md:mb-4 leading-snug fade-in-up drop-shadow-sm" style="animation-delay: 0.2s;">
                        رونق التصميم
                    </h1>
                    <p class="text-base sm:text-lg text-morris-cream/85 leading-relaxed font-light fade-in-up max-w-xl" style="animation-delay: 0.3s;">
                        تجربة فريدة لتصميم الأقمشة المستدامة، مستوحاة من عراقة الطبيعة وفلسفة الفنون والحرف لوليام موريس.
                    </p>
                    @if($isLoggedIn)
                    <div class="mt-6 fade-in-up" style="animation-delay: 0.35s;">
                        <span class="inline-flex items-center gap-2 bg-morris-cream/15 border border-morris-cream/20 text-morris-cream px-4 py-2 rounded-full text-sm font-semibold">
                            <span>👋</span>
                            <span>{{ $isArabic ? 'مرحباً، ' . session('participant_name') : 'Welcome, ' . session('participant_name') }}</span>
                        </span>
                    </div>
                    @endif
                </div>

                <div class="relative z-10 p-6 md:p-8 hidden md:flex md:w-2/5 justify-center items-center fade-in-up" style="animation-delay: 0.4s;">
                    <div class="relative w-24 h-24 md:w-36 md:h-36 lg:w-56 lg:h-56 flex items-center justify-center">
                        <svg class="absolute inset-0 w-full h-full text-morris-gold/30 animate-[spin_40s_linear_infinite]" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="48" fill="none" stroke="currentColor" stroke-width="1.2" stroke-dasharray="6 4" />
                        </svg>
                        <svg class="absolute inset-4 w-[calc(100%-2rem)] h-[calc(100%-2rem)] text-morris-gold/40" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="48" fill="none" stroke="currentColor" stroke-width="0.5" />
                        </svg>
                        <svg class="w-12 h-12 md:w-20 md:h-20 lg:w-28 lg:h-28 text-morris-gold drop-shadow-md" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-4 sm:pt-6 pb-12 lg:pb-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <div class="grid grid-cols-3 gap-2 sm:gap-3 lg:gap-6">

                <a href="{{ route('morris') }}" class="morris-frame rounded-xl p-2 sm:p-4 lg:p-8 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-300 shadow-morris hover:shadow-morris-hover border-t-4 border-t-morris-primary fade-in-up hover:bg-morris-primary/5" style="animation-delay: 0.4s;">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 lg:w-16 lg:h-16 rounded-full bg-morris-primary/15 text-morris-primary flex items-center justify-center mb-2 lg:mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h2 class="font-brand text-xs sm:text-sm lg:text-2xl text-morris-primary mb-1 lg:mb-3">وليام موريس</h2>
                    <p class="hidden lg:block text-sm text-morris-text/80 line-clamp-2">تعرفي على فلسفة الفنون والحرف والإلهام المستمد من الطبيعة.</p>
                    <div class="hidden lg:flex mt-5 text-morris-primary/40 group-hover:text-morris-primary transition-colors">
                        <svg class="w-6 h-6 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>

                <a href="{{ route('fabrics') }}" class="morris-frame rounded-xl p-2 sm:p-4 lg:p-8 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-300 shadow-morris hover:shadow-morris-hover border-t-4 border-t-morris-olive fade-in-up hover:bg-morris-olive/5" style="animation-delay: 0.5s;">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 lg:w-16 lg:h-16 rounded-full bg-morris-olive/15 text-morris-olive flex items-center justify-center mb-2 lg:mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <h2 class="font-brand text-xs sm:text-sm lg:text-2xl text-morris-olive mb-1 lg:mb-3">الأقمشة المستدامة</h2>
                    <p class="hidden lg:block text-sm text-morris-text/80 line-clamp-2">اكتشفي أنواع الأقمشة الصديقة للبيئة وكيفية العناية بها.</p>
                    <div class="hidden lg:flex mt-5 text-morris-olive/40 group-hover:text-morris-olive transition-colors">
                        <svg class="w-6 h-6 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>

                <a href="{{ route('technique') }}" class="morris-frame rounded-xl p-2 sm:p-4 lg:p-8 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-300 shadow-morris hover:shadow-morris-hover border-t-4 border-t-morris-indigo fade-in-up hover:bg-morris-indigo/5" style="animation-delay: 0.6s;">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 lg:w-16 lg:h-16 rounded-full bg-morris-indigo/15 text-morris-indigo flex items-center justify-center mb-2 lg:mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h2 class="font-brand text-xs sm:text-sm lg:text-2xl text-morris-indigo mb-1 lg:mb-3">النقشة الزائدة</h2>
                    <p class="hidden lg:block text-sm text-morris-text/80 line-clamp-2">تعلمي تقنيات النقشة الزائدة لإضافة لمسة فنية لأقمشتك.</p>
                    <div class="hidden lg:flex mt-5 text-morris-indigo/40 group-hover:text-morris-indigo transition-colors">
                        <svg class="w-6 h-6 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>
                @if($isLoggedIn)
                <a href="{{ route('design-tool') }}" id="open-modal-design" class="relative w-full morris-frame rounded-xl p-2 sm:p-4 lg:p-8 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-300 shadow-morris hover:shadow-morris-hover border-t-4 border-t-morris-gold fade-in-up hover:bg-morris-gold/5" style="animation-delay: 0.7s;">
                @else
                <button type="button" id="open-modal-design" data-open-login-modal class="relative w-full morris-frame rounded-xl p-2 sm:p-4 lg:p-8 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-300 shadow-morris hover:shadow-morris-hover border-t-4 border-t-morris-gold fade-in-up hover:bg-morris-gold/5" style="animation-delay: 0.7s;">
                @endif
                    @unless($isLoggedIn)
                    <div class="absolute top-1.5 right-1.5 lg:top-4 lg:right-4 w-5 h-5 lg:w-8 lg:h-8 rounded-full bg-white border border-morris-gold text-morris-gold flex items-center justify-center shadow-sm group-hover:bg-morris-gold group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    @endunless

                    <div class="w-8 h-8 sm:w-10 sm:h-10 lg:w-16 lg:h-16 rounded-full bg-morris-gold/15 text-morris-gold flex items-center justify-center mb-2 lg:mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                    </div>
                    <h2 class="font-brand text-xs sm:text-sm lg:text-2xl text-morris-gold mb-1 lg:mb-3">أداة التصميم</h2>
                    <p class="hidden lg:block text-sm text-morris-text/80 line-clamp-2">ابدئي بتصميم نقوشك الخاصة حصرياً للمشاركين.</p>
                    @if($isLoggedIn)
                    <div class="hidden lg:flex mt-5 text-morris-gold/40 group-hover:text-morris-gold transition-colors">
                        <svg class="w-6 h-6 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                    @else
                    <div class="hidden lg:block mt-4 text-morris-gold font-bold text-xs lg:text-sm bg-morris-gold/10 px-3 py-1 lg:px-4 lg:py-1.5 rounded-full border border-morris-gold/20">
                        يتطلب كود دخول
                    </div>
                    @endif
                @if($isLoggedIn)
                </a>
                @else
                </button>
                @endif

                @if($isLoggedIn)
                <a href="{{ route('survey') }}" id="open-modal-survey" class="relative w-full morris-frame rounded-xl p-2 sm:p-4 lg:p-8 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-300 shadow-morris hover:shadow-morris-hover border-t-4 border-t-morris-terracotta fade-in-up hover:bg-morris-terracotta/5" style="animation-delay: 0.8s;">
                @else
                <button type="button" id="open-modal-survey" data-open-login-modal class="relative w-full morris-frame rounded-xl p-2 sm:p-4 lg:p-8 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-300 shadow-morris hover:shadow-morris-hover border-t-4 border-t-morris-terracotta fade-in-up hover:bg-morris-terracotta/5" style="animation-delay: 0.8s;">
                @endif
                    @unless($isLoggedIn)
                    <div class="absolute top-1.5 right-1.5 lg:top-4 lg:right-4 w-5 h-5 lg:w-8 lg:h-8 rounded-full bg-white border border-morris-terracotta text-morris-terracotta flex items-center justify-center shadow-sm group-hover:bg-morris-terracotta group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    @endunless

                    <div class="w-8 h-8 sm:w-10 sm:h-10 lg:w-16 lg:h-16 rounded-full bg-morris-terracotta/15 text-morris-terracotta flex items-center justify-center mb-2 lg:mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h2 class="font-brand text-xs sm:text-sm lg:text-2xl text-morris-terracotta mb-1 lg:mb-3">الاستبيان</h2>
                    <p class="hidden lg:block text-sm text-morris-text/80 line-clamp-2">شاركينا رأيك حول تجربتك في استخدام أداة رونق.</p>
                    @if($isLoggedIn)
                    <div class="hidden lg:flex mt-5 text-morris-terracotta/40 group-hover:text-morris-terracotta transition-colors">
                        <svg class="w-6 h-6 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                    @else
                    <div class="hidden lg:block mt-4 text-morris-terracotta font-bold text-xs lg:text-sm bg-morris-terracotta/10 px-3 py-1 lg:px-4 lg:py-1.5 rounded-full border border-morris-terracotta/20">
                        يتطلب كود دخول
                    </div>
                    @endif
                @if($isLoggedIn)
                </a>
                @else
                </button>
                @endif

            </div>
        </div>
    </section>
</main>
<footer class="bg-white/80 backdrop-blur-sm border-t border-morris-border mt-auto">
    <div class="container mx-auto px-4 py-8 text-center">
        <p class="text-morris-text/60 text-sm">
            &copy; {{ date('Y') }} رونق - ريم السعوي. جميع الحقوق محفوظة.
        </p>
    </div>
</footer>

@if(!$isLoggedIn)
<div id="login-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-morris-text/40 modal-backdrop transition-opacity" data-close-modal></div>

    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 p-8 overflow-hidden border border-morris-border transform transition-all scale-95 opacity-0 duration-300" id="modal-panel">
        <svg class="absolute top-0 left-0 w-16 h-16 text-morris-primary/5 -translate-x-4 -translate-y-4" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
        <svg class="absolute bottom-0 right-0 w-24 h-24 text-morris-gold/10 translate-x-8 translate-y-8" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>

        <button type="button" data-close-modal class="absolute top-4 left-4 text-morris-text/50 hover:text-morris-terracotta transition-colors bg-morris-cream rounded-full p-2" aria-label="إغلاق">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="relative text-center">
            <div class="font-brand text-3xl text-morris-primary mb-2" id="modal-title">أهلاً بكِ في رونق</div>
            <p class="text-morris-text/70 mb-8 text-sm">أدخلي كود المشاركة للوصول إلى هذا القسم والمتابعة</p>

            <form id="modal-form" class="space-y-6" novalidate>
                <div>
                    <label for="modal-code" class="block text-right text-sm font-semibold text-morris-text mb-2">كود المشاركة</label>
                    <input
                        type="text"
                        id="modal-code"
                        name="code"
                        maxlength="4"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        placeholder="مثال: 1234"
                        class="w-full text-center text-2xl tracking-[0.5em] font-bold text-morris-primary bg-morris-cream border-2 border-morris-border rounded-xl px-4 py-4 focus:outline-none focus:border-morris-gold focus:ring-1 focus:ring-morris-gold transition-all"
                    >
                    <p id="modal-error" class="text-red-500 text-sm mt-2 hidden">يرجى إدخال كود صحيح</p>
                </div>

                <button type="submit" id="modal-submit" class="w-full bg-morris-terracotta hover:bg-morris-primary text-white font-bold text-lg py-4 rounded-xl shadow-md transition-colors duration-300 relative overflow-hidden group disabled:opacity-60 disabled:cursor-not-allowed">
                    <span class="relative z-10" id="modal-submit-label">ابدئي التجربة</span>
                    <div class="absolute inset-0 h-full w-full bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-out"></div>
                </button>
            </form>

            <p class="mt-6 text-xs text-morris-text/50">الرجاء استخدام كود المشاركة المكون من 4 أرقام المرسل لكِ مسبقاً.</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal       = document.getElementById('login-modal');
    const modalPanel  = document.getElementById('modal-panel');
    const openBtns    = document.querySelectorAll('[data-open-login-modal]');
    const closeBtns   = document.querySelectorAll('[data-close-modal]');
    const form        = document.getElementById('modal-form');
    const input       = document.getElementById('modal-code');
    const errorMsg    = document.getElementById('modal-error');
    const submitBtn   = document.getElementById('modal-submit');
    const submitLabel = document.getElementById('modal-submit-label');
    const csrfToken   = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const showError = (msg) => {
        errorMsg.textContent = msg || 'يرجى إدخال كود صحيح';
        errorMsg.classList.remove('hidden');
        input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        modalPanel.classList.add('animate-pulse');
        setTimeout(() => modalPanel.classList.remove('animate-pulse'), 500);
    };

    const clearError = () => {
        errorMsg.classList.add('hidden');
        input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
    };

    const openModal = (e) => {
        if (e) e.preventDefault();
        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            modalPanel.classList.remove('scale-95', 'opacity-0');
            modalPanel.classList.add('scale-100', 'opacity-100');
        });
        document.body.style.overflow = 'hidden';
        setTimeout(() => input.focus(), 300);
    };

    const closeModal = () => {
        modalPanel.classList.remove('scale-100', 'opacity-100');
        modalPanel.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            input.value = '';
            clearError();
        }, 300);
    };

    openBtns.forEach(btn => btn.addEventListener('click', openModal));
    closeBtns.forEach(btn => btn.addEventListener('click', closeModal));

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });

    input.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
        clearError();
    });

    @if($autoOpenModal)
    openModal();
    @endif

    const setLoading = (on) => {
        submitBtn.disabled = on;
        input.disabled     = on;
        if (on) {
            submitLabel.innerHTML = '<span class="inline-flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> جاري التحقق...</span>';
        } else {
            submitLabel.textContent = 'ابدئي التجربة';
        }
    };

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearError();

        const code = input.value.trim();
        if (code.length !== 4) {
            showError('الرجاء إدخال كود مكون من 4 أرقام');
            return;
        }

        setLoading(true);
        try {
            const res = await fetch('{{ route("login.post") }}', {
                method: 'POST',
                headers: {
                    'Accept':       'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ code }),
            });

            const data = await res.json().catch(() => ({}));

            if (!res.ok) {
                showError(
                    data.error || data.errors?.code?.[0] || data.message || 'حدث خطأ، يرجى المحاولة مجدداً'
                );
                return;
            }

            window.location.href = data.redirect ?? '{{ route("home") }}';
        } catch (err) {
            showError('حدث خطأ في الاتصال، يرجى المحاولة مجدداً');
        } finally {
            setLoading(false);
        }
    });
});
</script>
@endif
</body>
</html>
