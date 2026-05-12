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
                    <span class="text-morris-primary">الموضة المستدامة</span>
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
                <span class="h-px w-6 bg-morris-olive"></span>
                <span class="text-morris-olive font-magic text-lg">الموضة المستدامة</span>
                <span class="h-px w-6 bg-morris-olive"></span>
            </div>
            <h1 class="font-brand text-3xl text-morris-primary font-bold drop-shadow-sm leading-snug">{{ $page->title_ar }}</h1>
        </div>

        <!-- Hero Banner (hidden on mobile) -->
        <section class="hidden md:block py-8 lg:py-10">
            <div class="container mx-auto px-6 lg:px-8 max-w-7xl">
                <div class="relative rounded-3xl lg:rounded-[2.5rem] bg-morris-primary overflow-hidden shadow-2xl flex items-center justify-between border border-morris-olive/30 p-8 lg:p-12">
                    <div class="absolute inset-0 opacity-10" style="background-image:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M54.627 0l1.25 1.25-43.125 43.125-1.25-1.25L54.627 0zM29.5 0l1.25 1.25-23.75 23.75-1.25-1.25L29.5 0zM60 25.373l-1.25-1.25L15.625 67.25l1.25 1.25L60 25.373zM60 50.5l-1.25-1.25-15.625 15.625 1.25 1.25L60 50.5z\' fill=\'%23F8F5F0\' fill-opacity=\'1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>
                    <div class="absolute inset-3 border border-morris-cream/20 rounded-2xl lg:rounded-[2rem] pointer-events-none"></div>

                    <div class="relative z-10 w-3/5 lg:w-2/3 text-right pr-2 lg:pr-4">
                        <div class="inline-flex items-center gap-3 mb-3 lg:mb-4">
                            <span class="h-[2px] w-8 bg-morris-olive rounded-full"></span>
                            <span class="font-magic text-morris-cream/90 text-xl lg:text-2xl">الموضة المستدامة</span>
                        </div>
                        <h1 class="font-brand text-4xl lg:text-5xl text-morris-cream mb-4 lg:mb-6 leading-tight drop-shadow-md">{{ $page->title_ar }}</h1>
                        <p class="text-base lg:text-xl text-morris-cream/80 leading-relaxed font-light max-w-2xl">{{ $page->intro_ar }}</p>
                    </div>

                    <div class="relative z-10 w-2/5 lg:w-1/3 flex justify-end pl-2 lg:pl-4">
                        @if($page->hero_image)
                        <div class="relative w-40 h-56 lg:w-56 lg:h-72 rounded-t-[4rem] rounded-b-xl overflow-hidden border-4 border-morris-olive/30 shadow-portrait group">
                            <img src="{{ $page->hero_image }}" alt="{{ $page->title_ar }}" class="absolute inset-0 w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-morris-primary/60 via-transparent to-transparent opacity-80"></div>
                        </div>
                        @else
                        <div class="relative w-40 h-56 lg:w-56 lg:h-72 rounded-t-[4rem] rounded-b-xl overflow-hidden border-2 border-dashed border-morris-cream/40 bg-morris-primary/40 flex flex-col items-center justify-center text-morris-cream/60 shadow-portrait backdrop-blur-sm">
                            <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="font-brand text-center px-4 leading-snug text-sm">صورة مؤقتة</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content Area -->
        <section class="pb-24 pt-2 md:pt-6 relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl flex flex-col lg:flex-row gap-8 lg:gap-12 relative items-start">

                <!-- Table of Contents -->
                <aside class="w-full lg:w-1/4 sticky top-20 sm:top-24 lg:top-32 shrink-0 z-30 pt-2 lg:pt-0">
                    <div class="morris-frame rounded-xl lg:rounded-2xl p-2 sm:p-4 lg:p-6 shadow-md bg-white overflow-hidden relative">
                        <h4 class="font-brand text-xl text-morris-primary border-b border-morris-border pb-3 mb-3 hidden lg:block">دليل الأقمشة</h4>
                        <div class="relative w-full">
                            <div id="toc-scroll-hint" class="absolute top-0 bottom-0 left-0 w-12 bg-gradient-to-r from-white to-transparent pointer-events-none lg:hidden flex items-center justify-start z-10 transition-opacity duration-300">
                                <div class="bg-white/80 rounded-full p-1 shadow-sm backdrop-blur-sm -ml-1 text-morris-olive">
                                    <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </div>
                            </div>
                            <nav id="toc" class="flex lg:flex-col overflow-x-auto lg:overflow-visible no-scrollbar gap-1 snap-x font-semibold relative">
                                @foreach($page->sections as $sec)
                                <a href="#{{ $sec['anchor_id'] }}" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg">
                                    <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-olive/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
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
                        @if($sec['anchor_id'] !== 'intro')
                        <h3>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                            <span>{{ $sec['title_ar'] }}</span>
                        </h3>
                        @endif
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
