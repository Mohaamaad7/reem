<?php
$f = file_get_contents('c:\\laragon\\www\\reem1\\resources\\views\\pages\\fabrics.blade.php');

$heroHtml = <<<'HTML'
    <!-- Hero Banner (hidden on mobile) -->
    <section class="hidden md:block py-8 lg:py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl group min-h-[400px] bg-gray-900">
                @if(isset($page) && $page->hero_image)
                    <img src="{{ $page->hero_image }}" alt="صورة {{ $page->title_ar }}" class="absolute inset-0 w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-700 ease-in-out" style="filter:sepia(0.2)">
                @else
                    <div class="absolute inset-0 w-full h-full bg-morris-primary flex items-center justify-center opacity-90">
                        <svg class="w-24 h-24 text-morris-cream/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="absolute text-morris-cream/50 font-bold text-2xl mt-32">مكان صورة الهيرو</span>
                    </div>
                @endif
                
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
                
                <div class="absolute bottom-0 inset-x-0 p-10 lg:p-16 flex flex-col justify-end transform transition duration-500">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-medium mb-6 w-fit">
                        <span class="w-2 h-2 rounded-full bg-morris-olive animate-pulse"></span>
                        الموضة المستدامة
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight drop-shadow-lg font-amiri">
                        {{ $page->title_ar ?? 'الأقمشة المستدامة' }}
                    </h1>
                    @if(isset($page) && $page->subtitle_ar)
                        <p class="text-xl text-gray-200 max-w-2xl font-light leading-relaxed drop-shadow-md border-r-4 border-morris-olive pr-4">
                            {{ $page->subtitle_ar }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>
HTML;

$f = preg_replace('/<!-- Hero Banner \(hidden on mobile\).*?<\/section>/s', $heroHtml, $f);

file_put_contents('c:\\laragon\\www\\reem1\\resources\\views\\pages\\fabrics.blade.php', $f);
echo 'done';
