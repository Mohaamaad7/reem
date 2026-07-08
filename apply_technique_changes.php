<?php

$htmlPath = 'c:\\laragon\\www\\reem1\\code_artifact2.html';
$htmlContent = file_get_contents($htmlPath);

// Extract the sections
preg_match_all('/<section class="mb-12">(.*?)<\/section>/s', $htmlContent, $sectionMatches);

$sections = $sectionMatches[0]; // Full section HTMLs

$finalContent = '';
$tocEntries = [];
$sectionIdCounter = 1;

foreach ($sections as $sectionHtml) {
    // Determine a section ID and title based on the first h2 or h3
    if (preg_match('/<h[23][^>]*>(.*?)<\/h[23]>/s', $sectionHtml, $titleMatch)) {
        $title = strip_tags($titleMatch[1]);
        $title = trim(preg_replace('/\s+/', ' ', $title));
        // Remove trailing colon
        $title = rtrim($title, ':');
        $id = 'section-' . $sectionIdCounter;
        
        $tocEntries[] = ['id' => $id, 'title' => $title];
        
        // Inject id into the heading
        $sectionHtml = preg_replace('/(<h[23][^>]*)>/', '$1 id="' . $id . '">', $sectionHtml, 1);
        $sectionIdCounter++;
    }

    // Process image placeholders
    // Pattern to find <div class="image-placeholder..."> ... <span...>مكان صورة/شكل (X)</span> ... </div>
    $sectionHtml = preg_replace_callback('/<div\s+([^>]*class="[^"]*?image-placeholder[^"]*?"[^>]*)>.*?مكان (صورة|شكل)\s*\((.*?)\).*?<\/div>/s', function($matches) {
        $type = trim($matches[2]); // صورة or شكل
        $num = trim($matches[3]);  // 52, 14, 60،61
        
        // Map to filename
        $prefix = ($type == 'شكل') ? 'fig-' : 'img-';
        
        // Handle special case 60،61
        if ($num == '60،61') {
            $filename = 'img-60-61.jpg';
        } else {
            // some have a, b
            $filename = $prefix . $num . '.jpg';
            if (!file_exists("c:\\laragon\\www\\reem1\\public\\images\\technique\\" . $filename)) {
                if (file_exists("c:\\laragon\\www\\reem1\\public\\images\\technique\\" . $prefix . $num . "a.jpg")) {
                    $filename = $prefix . $num . "a.jpg";
                }
            }
        }
        
        $classes = 'w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300';
        
        return '<img src="{{ asset(\'images/technique/' . $filename . '\') }}" alt="' . $type . ' ' . $num . '" class="' . $classes . '">';
    }, $sectionHtml);

    // Replace the specific container div class with something cleaner if we want, but it's fine
    
    // Process styling for elements inside section to match Reem's design
    $sectionHtml = preg_replace('/<h2[^>]*>/', '<h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-3">', $sectionHtml);
    $sectionHtml = preg_replace('/<h3[^>]*>/', '<h3 class="text-2xl font-bold text-indigo-800 mb-4 mt-8">', $sectionHtml);
    $sectionHtml = preg_replace('/<h4[^>]*>/', '<h4 class="text-xl font-bold text-gray-700 mb-3 mt-6">', $sectionHtml);
    
    // Add text leading classes
    $sectionHtml = str_replace('<p>', '<p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">', $sectionHtml);
    $sectionHtml = str_replace('<span class="citation"', '<span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6"', $sectionHtml);
    $sectionHtml = str_replace('<figcaption', '<figcaption class="text-center mt-3 text-sm text-gray-500 font-medium"', $sectionHtml);
    
    $finalContent .= $sectionHtml . "\n\n";
}

// Now generate the TOC HTML
$tocHtml = '<div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 sticky top-24 mb-10 xl:mb-0">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
        <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
        </span>
        محتويات الصفحة
    </h3>
    <ul class="space-y-4 text-gray-600 font-medium">';

foreach ($tocEntries as $index => $entry) {
    $tocHtml .= '
        <li>
            <a href="#' . $entry['id'] . '" class="flex items-center gap-3 hover:text-indigo-600 transition-colors group">
                <span class="w-6 h-6 rounded-full bg-gray-50 text-gray-400 flex items-center justify-center text-sm group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                    ' . ($index + 1) . '
                </span>
                ' . $entry['title'] . '
            </a>
        </li>';
}
$tocHtml .= '</ul></div>';

// Now construct the final blade file
$bladeContent = "@extends('layouts.app')

@section('title', \$page->title_ar ?? 'تقنية النقشة الزائدة')

@push('styles')
<style>
    html { scroll-behavior: smooth; }
    .page-placeholder__card { opacity: 0; transform: translateY(20px); animation: fadeInUp 0.8s ease-out forwards; }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<main dir=\"rtl\" class=\"bg-gray-50/50 min-h-screen pb-20\">

    <!-- Hero Banner -->
    <section class=\"hidden md:block py-8 lg:py-10\">
        <div class=\"container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl\">
            <div class=\"relative rounded-3xl overflow-hidden shadow-2xl group min-h-[400px] bg-gray-900\">
                @if(\$page->hero_image)
                    <img src=\"{{ \$page->hero_image }}\" alt=\"صورة {{ \$page->title_ar }}\" class=\"absolute inset-0 w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-700 ease-in-out\" style=\"filter:sepia(0.2)\">
                @else
                    <img src=\"{{ asset('images/technique/hero.jpg') }}\" alt=\"Hero Image\" class=\"absolute inset-0 w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-700 ease-in-out\" style=\"filter:sepia(0.2)\">
                @endif
                
                <div class=\"absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent\"></div>
                
                <div class=\"absolute bottom-0 inset-x-0 p-10 lg:p-16 flex flex-col justify-end transform transition duration-500\">
                    <div class=\"inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-medium mb-6 w-fit\">
                        <span class=\"w-2 h-2 rounded-full bg-indigo-400 animate-pulse\"></span>
                        قسم التقنيات
                    </div>
                    <h1 class=\"text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight drop-shadow-lg font-amiri\">
                        {{ \$page->title_ar ?? 'تقنية النقشة الزائدة' }}
                    </h1>
                    @if(\$page->subtitle_ar)
                        <p class=\"text-xl text-gray-200 max-w-2xl font-light leading-relaxed drop-shadow-md border-r-4 border-indigo-400 pr-4\">
                            {{ \$page->subtitle_ar }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Header -->
    <section class=\"md:hidden bg-white border-b border-gray-100 pt-8 pb-6 px-4\">
        <div class=\"container mx-auto\">
            <div class=\"inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold mb-4\">
                قسم التقنيات
            </div>
            <h1 class=\"text-3xl font-bold text-gray-900 mb-3 font-amiri\">{{ \$page->title_ar ?? 'تقنية النقشة الزائدة' }}</h1>
            @if(\$page->subtitle_ar)
                <p class=\"text-gray-600 text-base leading-relaxed\">{{ \$page->subtitle_ar }}</p>
            @endif
        </div>
    </section>

    <!-- Content Area -->
    <div class=\"container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl pt-10\">
        <div class=\"flex flex-col xl:flex-row gap-10 lg:gap-16\">
            
            <!-- Table of Contents Sidebar -->
            <aside class=\"w-full xl:w-1/3 xl:flex-shrink-0\">
                $tocHtml
            </aside>

            <!-- Main Article Content -->
            <article class=\"w-full xl:w-2/3 bg-white p-6 md:p-10 lg:p-14 rounded-2xl shadow-sm border border-gray-100\">
                <div class=\"prose prose-lg prose-indigo max-w-none\">
                    $finalContent
                </div>
            </article>

        </div>
    </div>
</main>
@endsection
";

file_put_contents('c:\\laragon\\www\\reem1\\resources\\views\\pages\\technique.blade.php', $bladeContent);
echo "technique.blade.php generated successfully!";
