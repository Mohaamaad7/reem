<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title_ar }} - رونق</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="inner-page-bg antialiased min-h-screen flex flex-col relative">

    <!-- Header -->
    <header class="sticky top-0 z-40 bg-morris-cream/95 backdrop-blur-md border-b border-morris-border shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8" style="max-width:none;width:100%">
            <div class="flex items-center justify-between h-20 sm:h-24">
                <a href="{{ route('home') }}" class="flex flex-col items-center justify-center group relative">
                    <span class="font-brand text-3xl sm:text-4xl font-bold text-morris-primary tracking-wide">رونق</span>
                    <span class="font-magic text-lg sm:text-xl text-morris-terracotta mt-[-4px]">ريم السعوي</span>
                </a>

                <div class="hidden md:flex items-center gap-2 text-sm font-semibold text-morris-text/60">
                    <a href="{{ route('home') }}" class="hover:text-morris-terracotta transition">الرئيسية</a>
                    <span>/</span>
                    <span class="text-morris-primary">{{ $page->title_ar }}</span>
                </div>

                <a href="{{ route('home') }}" class="flex items-center gap-2 bg-morris-cream border border-morris-primary text-morris-primary hover:bg-morris-primary hover:text-white px-4 py-2 rounded-full transition-colors duration-300 shadow-sm text-sm sm:text-base font-semibold">
                    <span>العودة</span>
                    <svg class="w-4 h-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow">

        <!-- Mobile-only title -->
        <div class="md:hidden container mx-auto px-4 py-6 text-center" style="max-width:none;width:100%">
            <div class="inline-flex items-center justify-center gap-2 mb-2">
                <span class="h-px w-6 bg-morris-gold"></span>
                <span class="text-morris-gold font-magic text-lg">شخصيات خالدة</span>
                <span class="h-px w-6 bg-morris-gold"></span>
            </div>
            <h1 class="font-brand text-4xl text-morris-primary font-bold drop-shadow-sm">{{ $page->title_ar }}</h1>
        </div>

        <!-- Hero Banner (hidden on mobile) -->
        <section class="hidden md:block py-8 lg:py-10">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="relative rounded-3xl lg:rounded-[2.5rem] bg-morris-primary overflow-hidden shadow-2xl flex items-center justify-between border border-morris-gold/20 p-8 lg:p-12">
                    <div class="absolute inset-0 opacity-[0.03]" style="background-image:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23F8F5F0\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                    <div class="absolute inset-3 border border-morris-gold/10 rounded-2xl lg:rounded-[2rem] pointer-events-none"></div>

                    <div class="relative z-10 w-3/5 lg:w-2/3 text-right pr-2 lg:pr-4">
                        <div class="inline-flex items-center gap-3 mb-3 lg:mb-4">
                            <span class="h-[2px] w-8 bg-morris-gold rounded-full"></span>
                            <span class="font-magic text-morris-gold text-xl lg:text-2xl">شخصيات خالدة</span>
                        </div>
                        <h1 class="font-brand text-4xl lg:text-6xl text-morris-cream mb-4 lg:mb-6 leading-tight drop-shadow-md">{{ $page->title_ar }}</h1>
                        <p class="text-base lg:text-xl text-morris-cream/90 leading-relaxed font-light max-w-2xl">{{ $page->intro_ar }}</p>
                    </div>

                    <div class="relative z-10 w-2/5 lg:w-1/3 flex justify-end pl-2 lg:pl-4">
                        <div class="relative w-40 h-56 lg:w-56 lg:h-72 rounded-t-[4rem] rounded-b-xl overflow-hidden border-4 border-morris-gold/30 shadow-portrait bg-morris-primary/50 group">
                            @if($page->hero_image)
                                <img src="{{ $page->hero_image }}" alt="صورة {{ $page->title_ar }}" class="absolute inset-0 w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-700 ease-in-out" style="filter:sepia(0.2)">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-morris-cream/40">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-morris-primary/60 via-transparent to-transparent opacity-80"></div>
                            <div class="absolute inset-2 border border-morris-gold/40 rounded-t-[3.5rem] rounded-b-lg pointer-events-none"></div>
                            <div class="absolute bottom-3 w-full text-center">
                                <span class="font-magic text-sm lg:text-base text-morris-cream drop-shadow-md">المصمم العبقري</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content Area -->
        <section class="pb-24 pt-2 md:pt-6 relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row gap-8 lg:gap-12 relative items-start">

                <!-- Table of Contents -->
                <aside class="w-full lg:w-1/4 sticky top-20 sm:top-24 lg:top-32 shrink-0 z-30 pt-2 lg:pt-0">
                    <div class="morris-frame rounded-xl lg:rounded-2xl p-2 sm:p-4 lg:p-6 shadow-md bg-white overflow-hidden relative">
                        <h4 class="font-brand text-xl text-morris-primary border-b border-morris-border pb-3 mb-3 hidden lg:block">محتويات التقرير</h4>
                        <div class="relative w-full">
                            <div id="toc-scroll-hint" class="absolute top-0 bottom-0 left-0 w-12 bg-gradient-to-r from-white to-transparent pointer-events-none lg:hidden flex items-center justify-start z-10 transition-opacity duration-300">
                                <div class="bg-white/80 rounded-full p-1 shadow-sm backdrop-blur-sm -ml-1 text-morris-gold">
                                    <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </div>
                            </div>
                            <nav id="toc" class="flex lg:flex-col overflow-x-auto lg:overflow-visible no-scrollbar gap-1 snap-x font-semibold relative">
                                @foreach($page->sections as $sec)
                                <a href="#{{ $sec['anchor_id'] }}" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg">
                                    <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-gold/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    <span>{{ $sec['title_ar'] }}</span>
                                </a>
                                @endforeach
                            </nav>
                        </div>
                    </div>
                </aside>

                <!-- Article Content -->
                <div class="w-full lg:w-3/4 article-content bg-white/60 p-6 sm:p-8 lg:p-12 rounded-3xl shadow-sm border border-morris-border/50">
                    @foreach($page->sections as $sec)
                    <section id="{{ $sec['anchor_id'] }}" class="scroll-mt-40 lg:scroll-mt-32 {{ !$loop->last ? 'mb-16' : '' }}">
                        <h3>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <span>{{ $sec['title_ar'] }}</span>
                        </h3>
                        {!! $sec['body_ar'] !!}
                    </section>
                    @endforeach
                </div>

            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-morris-border mt-auto">
        <div class="container mx-auto px-4 py-8 text-center" style="max-width:none;width:100%">
            <p class="text-morris-text/60 text-sm font-semibold">&copy; {{ date('Y') }} رونق - ريم السعوي. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.toc-link');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');
                        navLinks.forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === `#${id}`) {
                                link.classList.add('active');
                                if (window.innerWidth < 1024) {
                                    link.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                                }
                            }
                        });
                    }
                });
            }, { root: null, rootMargin: '-20% 0px -60% 0px', threshold: 0 });
            sections.forEach(s => observer.observe(s));

            const tocContainer = document.getElementById('toc');
            const scrollHint   = document.getElementById('toc-scroll-hint');
            if (tocContainer && scrollHint) {
                tocContainer.addEventListener('scroll', () => {
                    scrollHint.style.opacity = Math.abs(tocContainer.scrollLeft) > 10 ? '0' : '1';
                    scrollHint.style.pointerEvents = Math.abs(tocContainer.scrollLeft) > 10 ? 'none' : '';
                }, { passive: true });
            }
        });
    </script>
</body>
</html>
