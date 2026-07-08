@extends('layouts.premium', ['pageTitle' => 'تقنيات النسيج', 'backRoute' => route('home')])

@section('title', $page->title_ar . ' - رونق')

@section('content')
    <!-- Mobile-only title -->
    <div class="md:hidden container mx-auto px-4 py-6 text-center">
        <div class="inline-flex items-center justify-center gap-2 mb-2">
            <span class="h-px w-6 bg-morris-olive"></span>
            <span class="text-morris-olive font-magic text-lg">تقنيات النسيج</span>
            <span class="h-px w-6 bg-morris-olive"></span>
        </div>
        <h1 class="font-brand text-3xl text-morris-primary font-bold drop-shadow-sm leading-snug">{{ $page->title_ar }}</h1>
    </div>

    <!-- Hero Banner (hidden on mobile) -->
    <section class="hidden md:block py-8 lg:py-10">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="relative rounded-3xl lg:rounded-[2.5rem] bg-morris-primary overflow-hidden shadow-2xl flex items-center justify-between border border-morris-olive/30 p-8 lg:p-12">
                <div class="absolute inset-0 opacity-10" style="background-image:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M54.627 0l1.25 1.25-43.125 43.125-1.25-1.25L54.627 0zM29.5 0l1.25 1.25-23.75 23.75-1.25-1.25L29.5 0zM60 25.373l-1.25-1.25L15.625 67.25l1.25 1.25L60 25.373zM60 50.5l-1.25-1.25-15.625 15.625 1.25 1.25L60 50.5z\' fill=\'%23F8F5F0\' fill-opacity=\'1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>
                <div class="absolute inset-3 border border-morris-cream/20 rounded-2xl lg:rounded-[2rem] pointer-events-none"></div>

                <div class="relative z-10 w-3/5 lg:w-2/3 text-right pr-2 lg:pr-4">
                    <div class="inline-flex items-center gap-3 mb-3 lg:mb-4">
                        <span class="h-[2px] w-8 bg-morris-olive rounded-full"></span>
                        <span class="font-magic text-morris-cream/90 text-xl lg:text-2xl">تقنيات النسيج</span>
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
                    <div class="relative w-40 h-56 lg:w-56 lg:h-72 rounded-t-[4rem] rounded-b-xl overflow-hidden border-4 border-morris-olive/30 shadow-portrait group">
                        <img src="{{ asset('images/technique/hero.jpg') }}" alt="النقشة الزائدة" class="absolute inset-0 w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-morris-primary/60 via-transparent to-transparent opacity-80"></div>
                    </div>
                    @endif
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
                    <h4 class="font-brand text-xl text-morris-primary border-b border-morris-border pb-3 mb-3 hidden lg:block">دليل المحتوى</h4>
                    <div class="relative w-full">
                        <div id="toc-scroll-hint" class="absolute top-0 bottom-0 left-0 w-12 bg-gradient-to-r from-white to-transparent pointer-events-none lg:hidden flex items-center justify-start z-10 transition-opacity duration-300">
                            <div class="bg-white/80 rounded-full p-1 shadow-sm backdrop-blur-sm -ml-1 text-morris-olive">
                                <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </div>
                        </div>
                        <nav id="toc" class="flex lg:flex-col overflow-x-auto lg:overflow-visible no-scrollbar gap-1 snap-x font-semibold relative">
                            <a href="#sec-1" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg ">
                                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-olive/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span>مقدمة</span>
                            </a>
                            <a href="#sec-2" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg pl-2 lg:pl-4 ">
                                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-olive/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span>مفهوم التركيب النسجي</span>
                            </a>
                            <a href="#sec-3" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg pl-2 lg:pl-4 ">
                                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-olive/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span>مفهوم النقشة الزائدة</span>
                            </a>
                            <a href="#sec-4" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg pl-2 lg:pl-4 ">
                                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-olive/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span>التطور التاريخي</span>
                            </a>
                            <a href="#sec-5" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg pl-2 lg:pl-4 ">
                                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-olive/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span>العصر الفرعوني</span>
                            </a>
                            <a href="#sec-6" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg pl-2 lg:pl-4 ">
                                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-olive/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span>العصر القبطي</span>
                            </a>
                            <a href="#sec-7" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg pl-2 lg:pl-4 ">
                                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-olive/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span>العصر الإسلامي</span>
                            </a>
                            <a href="#sec-8" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg pl-2 lg:pl-4 ">
                                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-olive/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span>الأساليب التقنية</span>
                            </a>
                            <a href="#sec-9" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg pl-2 lg:pl-4 ">
                                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-olive/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span>اللحمة الزائدة التقليدية والحقيقية</span>
                            </a>
                            <a href="#sec-10" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg pl-2 lg:pl-4 ">
                                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-olive/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span>تحبيس النقوش الزائدة</span>
                            </a>
                            <a href="#sec-11" class="toc-link flex items-center gap-2 snap-start shrink-0 lg:shrink px-3 lg:px-4 py-2 text-xs sm:text-sm lg:text-base border-r-2 border-transparent text-morris-text/70 hover:text-morris-terracotta hover:bg-morris-cream transition-colors rounded-l-lg pl-2 lg:pl-4 ">
                                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-morris-olive/70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span>تصميمات على ورق المربعات</span>
                            </a>
                        </nav>
                    </div>
                </div>
            </aside>

            <!-- Article Content -->
            <div class="w-full lg:w-3/4 article-content bg-white/60 p-6 sm:p-8 lg:p-12 rounded-3xl shadow-sm border border-morris-border/50">

        <section class="mb-14">
            <h2 id="sec-1" class="scroll-mt-40 lg:scroll-mt-32 text-2xl font-bold text-gray-800 mb-6 border-r-4 border-green-500 pr-3">ثالثاً: توظيف النقشة الزائدة في الأقمشة الصديقة للبيئة</h2>
            <h3 class="text-xl font-bold text-gray-700 mb-3">مقدمة:</h3>
            <p>
                عرفت الصناعة النسيجية قبل التاريخ منذ العصور القديمة حيث ان الحضارات القديمة لا تخلو من آثار تدل على أن صناعة النسيج كانت تزاول على درجات متفاوتة، كما أثبتت لنا النقوش والآثار الموجودة على جدران المقابر والمعابد أن صناعة المنسوجات كانت من الصناعات اليدوية التي مارسها الانسان منذ أمد بعيد.
            </p>
            <span class="citation">(أنصاف نصر، وكوثر الزغبي، 1981، ص 291)</span>

            <figure class="my-8">
                <img src="{{ asset('images/technique/img-52.jpg') }}" class="w-full md:w-3/4 mx-auto h-auto object-cover rounded-2xl shadow-md" alt="صورة 52 - نسيج التابستري">
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (52) نسيج التابستري<br>
                    <span dir="ltr">(Stauffer, A., 1995, P.32)</span>
                </figcaption>
            </figure>

            <p>
                تنوعت التراكيب النسجية التي عرفت منذ العصور القديمة وكان الهدف الأساسي دائما الحصول على منسوج قوي وجميل، وعلى زخارف نسجية تميز صناع الأقمشة ومصمميها، كما أن العصور القديمة قد استعملت طرق مختلفة للحصول على الزخارف منها طريقة القباطي وهو النسيج المعروف بـ (التبستري) يظهر في صورة (52)، وطريقة النسيج الوبري، وطريقة النقشة الزائدة، بهذه الطرق تتداخل التراكيب النسجية اذ يمكن الحصول على عدد لا يحصى من النماذج المختلفة والمتنوعة.
            </p>
            <span class="citation">(سعد كامل، 1976، ص 53)</span>
            <p>
                يعتبر نسيج النقشة الزائدة "التقليدية - والحقيقية" أحد التقنيات والطرق المستخدمة في تصميم وزخرفة المنسوجات منذ القدم، وقد قسمت القطع التي نسجت زخارفها بطريقة اللحمة الزائدة التقليدية من ناحية المواد الخام إلى مجموعتين: (مجموعة قطعها من الكتان الغير ملون والخيوط المستعملة في اللحمة التقليدية أكثر بياضًا وأسمك من أرضية النسيج ذلك حتى تظهر على سطح النسيج وهذه زخارفها مكونة عادة من زخارف هندسية بسيطة، ومجموعة تتكون أرضيتها وزخارفها من الصوف وتمتاز عن القطع الأخرى بأنها نسيج سميك ذات ألوان باهته).
            </p>
            <span class="citation">(سعاد ماهر، 1977، 66-68)</span>

            <div class="footnote bg-gray-50 border-r-4 border-morris-olive/40 rounded-lg p-4 mt-6 text-sm text-gray-600">
                (10) تابستري: نوع من أنواع الزخرفة المنسوجة الذي ينفذ على الأنوال اليدوية التي عرفت بمصر قديما، يعرفه معجم المصطلحات النسجية بأنه نسيج ذو طابع زخرفي، يتم نسجه بنسيج سادة 1/1، فيه تغطي اللحمات خيوط السداء، وتظهر على شكل تضليعات طولية.<br>
                (نيرفانا عبد الباقي، 2023، ص 524)
            </div>
        </section>

        <section class="mb-14">
            <h3 id="sec-2" class="scroll-mt-40 lg:scroll-mt-32 text-xl font-bold text-gray-700 mt-8 mb-2">مفهوم التركيب النسجي:</h3>
            <p>
                طريقة يتم بواسطتها تعاشق او تشابك كلا من خيوط السداء واللحمة معا لتكوين المنسوج، وتعتبر التراكيب النسجيه أحد أهم العوامل الرئيسية في التركيب البنائي التي يعتمد عليها المصمم في التوصل الى خواص المنسوج المطلوب تحقيقها حيث انها تقوم بدور هام في تحديد جودة المنتج النهائي ومدى تناسبه لأدائه الوظيفي، وشكل (14) يوضح تعاشق الخيوط في التركيب النسجي.
            </p>
            <span class="citation">(فتحي السماديسي، 2018، ص2)</span>

            <figure class="my-8">
                <img src="{{ asset('images/technique/fig-14.jpg') }}" class="w-full md:w-1/2 mx-auto h-auto object-cover rounded-2xl shadow-md" alt="شكل 14 - تعاشق الخيوط في التركيب النسجي">
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (14) تعاشق الخيوط في التركيب النسجي<br>
                    <span dir="ltr">(https://areq.net)</span>
                </figcaption>
            </figure>

            <h3 id="sec-3" class="scroll-mt-40 lg:scroll-mt-32 text-xl font-bold text-gray-700 mt-8 mb-2">مفهوم النقشة الزائدة:</h3>
            <p>
                نسيج من منسوجات النسيج السادة مضاف لها خيوط زائدة في السداء واللحمة على سطح المنسوج مكونة زخرفة، اذ تتخلل الخيوط الأرضية للمنسوج الأصلي وغالبا ما تكون هذه الأرضية نسيج سادة، كما في صورة (53).
            </p>
            <span class="citation">(محمد الشربيني، 1972، ص 32)</span>

            <figure class="my-8">
                <img src="{{ asset('images/technique/img-53.jpg') }}" class="w-full md:w-2/3 mx-auto h-auto object-cover rounded-2xl shadow-md" alt="صورة 53 - قطعة أثرية لأسلوب نسيج النقشة الزائدة">
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (53) قطعة اثرية لاسلوب نسيج النقشة الزائدة<br>
                    (منال الصالح، 2014، ص 34)
                </figcaption>
            </figure>
        </section>

        <section class="mb-14">
            <h2 id="sec-4" class="scroll-mt-40 lg:scroll-mt-32 text-2xl font-bold text-gray-800 mb-6 border-r-4 border-green-500 pr-3">التطور التاريخي لنسيج النقشة الزائدة:</h2>
            <p>
                تطورت النقشة الزائدة عبر العصور القديمة، حيث تنوعت في كل عصر من العصور، واستخدمت في صناعة وتنفيذ نسيج النقشة الزائدة مواد خام اذ يقع في المركز الأول الكتان يليه الصوف في المركز الثاني، وجاء في المركز الثالث الحرير، اما القطن فقد ورد ذكره في المصادر القديمة.
            </p>

            <h3 id="sec-5" class="scroll-mt-40 lg:scroll-mt-32 text-xl font-bold text-gray-700 mt-8 mb-2">النقشة الزائدة في العصر الفرعوني:</h3>
            <p>
                ينفذ النسيج داخل المصانع الملكية التي توفر حاجات الملك وبلاطه، وكانت صناعة المعابد تنافس الصناعة الملكية، حيث ان لكل معبد مصنعه الخاص الذي يُعد وينتج حاجات الآلهة والكهنه، كما توفرت العديد من الخامات التي أتاحت الفرصة الكبيرة في عمل توليفات جذابة ظهرت في العديد من القطع النسجية الاثرية الموجودة في المتحف المصري بالقاهرة والتي عثر عليها في المقابر، وقد قسم النساجين في العصر الفرعوني الزخرفة النسجية الى توليف خيوط الكتان الخام والكتان الملون، وتوليف خيوط الصوف الملون، والكتان الخام، توليف عن طريق استخدام أساليب نسجية مختلفة عن بعضها البعض.
            </p>
            <span class="citation">(سعاد ماهر، 1986، ص 64)</span>

            <p>
                تظهر صورة (54) نسيج النقشة الزائدة في العصر الفرعوني، ويوضح التحليل الوصفي لها، الخامات المستخدمة خيوط كتان خام، وخيوط صوف ملون، والصباغة والألوان المستخدمة متملثة باللون الأخضر، والاحمر، وتصنيع نسيج النقشة الزائدة يُظهر الزخرفة بخيوط الصوف الملون واذ تمثلت الوانه باللونين "الأخضر، والأحمر"، وظهرت خيوط الصوف الخضراء منسوجة في جسم الطائر الذي يبدو في وضع السكون، كما نسجت خيوط الصوف الحمراء في أرجله ومنقاره وجزء من أجنحته، بالإضافة الى أوراق زهرة اللوتس نسجت بخيوط الصوف الأحمر وقاعدتها بخيوط الصوف الخضراء.
            </p>

            <figure class="my-8">
                <img src="{{ asset('images/technique/img-54.jpg') }}" class="w-full md:w-3/4 mx-auto h-auto object-cover rounded-2xl shadow-md" alt="صورة 54 - جزء من رداء يرجع للعصر الفرعوني">
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (54) توضح جزء من رداء يرجع للعصر الفرعوني<br>
                    (كفاية احمد، وآخرون، 2001، ص 163)
                </figcaption>
            </figure>
        </section>

        <section class="mb-14">
            <h3 id="sec-6" class="scroll-mt-40 lg:scroll-mt-32 text-xl font-bold text-gray-700 mt-8 mb-2">النقشة الزائدة في العصر القبطي:</h3>
            <p>
                يعتبر فن النسيج به فناً شعبياً انتشر في جميع المدن، كانت المنسوجات الكتانية تصنع في مدن مصر السفلى نظراً لملاءمتها للمناخ بينما كانت المنسوجات الصوفية تنتج في مدن مصر العليا، إذ يعتبر الكتان والصوف من الخامات الأساسية في معظم المنسوجات القبطية، كما كان من النادر استخدام الحرير.
            </p>
            <span class="citation">(سعاد ماهر حشمت مسیحه، 1957، ص 20)</span>

            <p>
                يعد اول من ابتكر طريقة النسيج بالنقشة الزائدة هم الأقباط المصريين، يوجد بعض القطع في المتحف المصري والمتحف القبطي قد استعمل فيها الخيوط الكتانية المبيضة "البيضاء"، كلحمة زائدة زخرفية على مسافات منتظمة، واستخدم الصوف المصبوغ باللون الكحلي أو الأحمر على الأرضية، وقد نفذت هذه القطع جمعها على هيئة أشرطة منفصلة تخاط بالأقمشة والقمصان من الجانبين.
            </p>
            <span class="citation">(مصطفى محمد، 1969، ص 30)</span>

            <p>
                يظهر أسلوب النقشة الزائدة عند الاقباط في صورة (55) اذ يوضح الوصف التحليلي لها، الخامات المستخدمة خيوط كتان خام وصوف ملون وتمثلت الألوان والصبغات باللون الأسود والاحمر والاخضر والبرتقالي، ظهر أسلوب النقشة الزائدة بنسج الزمار بخيوط الصوف الأسود لأنه يعتبر من عامة الشعب.
            </p>

            <figure class="my-8">
                <img src="{{ asset('images/technique/img-55.jpg') }}" class="w-full md:w-3/4 mx-auto h-auto object-cover rounded-2xl shadow-md" alt="صورة 55 - جزء من ستارة ترجع للعصر القبطي">
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (55) جزء من ستارة ترجع للعصر القبطي<br>
                    <span dir="ltr">(https://egymonuments.gov.eg)</span>
                </figcaption>
            </figure>

            <h3 id="sec-7" class="scroll-mt-40 lg:scroll-mt-32 text-xl font-bold text-gray-700 mt-8 mb-2">النقشة الزائدة في العصر الإسلامي:</h3>
            <p>
                اذ تعد صناعة النسيج فيه موضع التقدير ومضرب الأمثال في الدقة والجمال، حيث تم الاستفادة من هذا التراث الفني وتشجيعه من العرب حتى ازدهرت صناعة النسيج في العالم الإسلامي عامة ومصر خاصة، وبلغت درجة عالية من الكمال والاتقان، وظهر فن النسيج في كسوة الكعبة التي يقدسها العرب قبل وبعد الإسلام.
            </p>
            <span class="citation">(سعاد ماهر، 1977، ص 9)</span>

            <p>
                وذكرت كفاية أحمد، وآخرون، 2001، ص (29) ان أساليب الزخرفة النسجية تنقسم لدى النساجين في العصر الإسلامي الى: "توليف خيوط الكتان الخام والملون وخيوط الذهب، وتوليف بين خيوط الكتان الخام والحرير الملون، بالإضافة الى توليف خيوط الكتان الخام وخيوط الصوف الملون، والتوليف بين خيوط الكتان الخام والقطن الملون".
            </p>

            <p>
                ظهر ذلك في صورة (56)، اذ يبين التحليل الوصفي لها، الخامات المستخدمة بالكتان الخام والصوف الملون، وظهر اسلوب النقشة الزائدة في القطعة المنسوجة من الكتان الملون يوجد بها شريط عريض من الكتابة التي نسجت حروفها من الكتان الابيض تنص العبارة الموجودة عليها بـ "بركة من الله لعبد".
            </p>

            <figure class="my-8">
                <img src="{{ asset('images/technique/img-56.jpg') }}" class="w-full md:w-3/4 mx-auto h-auto object-cover rounded-2xl shadow-md" alt="صورة 56 - جزء من نسيج">
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (56) جزء من نسيج<br>
                    (سعاد ماهر، 1977، ص 276)
                </figcaption>
            </figure>
        </section>

        <section class="mb-14">
            <h2 id="sec-8" class="scroll-mt-40 lg:scroll-mt-32 text-2xl font-bold text-gray-800 mb-6 border-r-4 border-green-500 pr-3">الأساليب التقنية لنسيج النقشة الزائدة:</h2>
            <p>
                تعتبر منسوجات النقشة الزائدة منسوجات عادية بسيطة مضافًا إليها خيوط زائدة التكوين الزخرفة أو التصميم، حيث تتخلل الخيوط الأرضية الاصلية للمنسوج بترتيب خاص مع ظهور تشييفها او حبسها وفق الرغبة على وجه القماش في أماكن خاصة حسب الزخرفة أو الأثير المطلوب.
            </p>
            <span class="citation">(منال عبدالله الصالح، 2014، ص)</span>

            <p>
                تتكون هذه المنسوجات من استخدام خيوط زائدة بالمنسوج الأصلي اما عن طريق اللحمة وتسمى نقشة زائدة من اللحمة او عن طريق السداء وتسمى خيوط زائدة من السداء، وتمتد الخيوط الزائدة على سطح المنسوج لتكوين النقش المطلوب اظهاره وتختفي في ظهر القماش بحيث يمكن سحبها الى الخارج دون ان يؤثر على متانة القماش.
            </p>
            <span class="citation">(جمال عبد الحميد، وآخرون، 2021، ص 173)</span>

            <h3 class="text-xl font-bold text-gray-700 mt-8 mb-3">أولاً / أساليب لاتجاه النسيج:</h3>
            <ol class="list-decimal list-inside space-y-4 text-gray-800">
                <li>
                    <strong>نسيج النقشة الزائدة من السداء (Extra Warp):</strong> الزائد بلون واحد او لونين في نفس النقشة كما في شكل (16)، بحيث يكون خيط السداء للأرضية ثم خيط اسداء للنقش أو ترتيب خيطين سداء أرضية وخيط للنقش طبقًا لقطر الخيوط المستخدمة في سداء النقش الزائد، يظهر ذلك في صورة (57).
                    <span class="citation inline mr-2">(مصطفی زاهر، 1997، ص 139)</span>
                </li>
            </ol>

            <div class="flex flex-col md:flex-row gap-6 my-8">
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-16.jpg') }}" class="w-full h-auto object-cover rounded-2xl shadow-md" alt="شكل 16 - تصميم النقشة الزائدة من السداء على ورق المربعات">
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (16) يوضح تصميم النقشة الزائدة من السداء على ورق المربعات
                    </figcaption>
                </figure>
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/img-57.jpg') }}" class="w-full h-auto object-cover rounded-2xl shadow-md" alt="صورة 57 - نسيج النقشة الزائدة من السداء">
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        صورة (57) نسيج النقشة الزائدة من السداء<br>
                        <span dir="ltr">https://textilelearner.net</span>
                    </figcaption>
                </figure>
            </div>

            <ol start="2" class="list-decimal list-inside space-y-4 text-gray-800">
                <li>
                    <strong>نسيج النقشة الزائدة من اللحمة (Extra Weft):</strong> نسيج عادي يتم إضافة اليها لحمة زائدة تتخلل الحمة الاصلية بترتيب خاص وفق تصميم معين يتم تنفيذ نسيج النقشة الزائدة من اللحمة بطريقتين وهي كما يلي:
                </li>
            </ol>

            <h4 class="font-bold text-gray-700 mt-4 pr-6">الطريقة الأولى اللحمة الزائدة التقليدية (Immitation Extra Weft):</h4>
            <p class="pr-6">
                يذكر (نبيل إبراهيم 2001، ص 13) للتنفيذ هذا النوع نحتاج الى سداء واحد ولحمة واحدة بحيث تشترك اللحمة الزائدة في تكوين أرضية النسيج فتصبح جزء من التركيب النسجي للمنسوج، ولو تم نزع اللحمة الزائدة ينتج تشييف لخيوط السداء وغالبا ماتكون الزخارف بلون الأرضية، كما في صورة (58)، وصورة (59).
            </p>

            <div class="flex flex-col md:flex-row gap-6 my-8">
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/img-58.jpg') }}" class="w-full h-auto object-cover rounded-2xl shadow-md" alt="صورة 58 - أسلوب النقشة الزائدة من اللحمة بعد التنفيذ">
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        صورة (58) توضح أسلوب النقشة الزائدة من اللحمة بعد التنفيذ.<br>
                        <span dir="ltr">(https://creative-threads.co.uk)</span>
                    </figcaption>
                </figure>
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/img-59.jpg') }}" class="w-full h-auto object-cover rounded-2xl shadow-md" alt="صورة 59 - وسادة منسوجة بأسلوب اللحمة التقليدية">
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        صورة (59) وسادة منسوجة بأسلوب اللحمة التقليدية<br>
                        (منال الصالح، 2014، ص 35)
                    </figcaption>
                </figure>
            </div>

            <h4 class="font-bold text-gray-700 mt-4 pr-6">الطريقة الثانية اللحمة الزائدة الحقيقية (Extra Weft Fabrics):</h4>
            <p class="pr-6">
                زخارف ونقشات تظهر على سطح القماش بإستخدام حركة لحمات زائدة توضع بين اللحمات الأصلية للقماش ومهمتها تقوم بعمل النقش على القماش دون أن تؤثر على التركيب الأصلي للقماش.
            </p>
            <span class="citation pr-6">(أسامة عز الدين، 2018، 283)</span>

            <ol start="3" class="list-decimal list-inside space-y-4 text-gray-800 mt-6">
                <li>
                    <strong>نسيج النقشة الزائدة من كلا الاتجاهين (Extra Weft And Warp):</strong><br>
                    وضح (مصطفى زاهر، 1997، ص 143) أن من الممكن الجمع بين النوعين (النقشة الزائدة من السداء، والنقشة الزائدة من اللحمة) في تصميم واحد ويلزم في هذه الحالة استخدام مطوتين سداء، واحدة لسداء الأرضية والأخرى لسداء النقشة، وشكل (17) يوضح تصميم النقشة الزائدة من كلا الاتجاهين.
                </li>
            </ol>

            <figure class="my-8">
                <img src="{{ asset('images/technique/fig-17.jpg') }}" class="w-full md:w-1/2 mx-auto h-auto object-cover rounded-2xl shadow-md" alt="شكل 17 - تصميم النقشة الزائدة من كلا الاتجاهين">
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (17) يوضح تصميم النقشة الزائدة من كلا الاتجاهين على ورق المربعات
                </figcaption>
            </figure>
        </section>

        <section class="mb-14">
            <h3 id="sec-9" class="scroll-mt-40 lg:scroll-mt-32 text-xl font-bold text-gray-700 mb-3">ثانياً الأساليب التقليدية والحقيقية:</h3>
            <h4 class="font-bold text-gray-800 text-lg">1 - اللحمة الزائدة "التقليدية":</h4>

            <p class="mt-3 font-semibold text-gray-700">اللحمة الزائدة ذات وجه سداء (Warp Faced Overshot):</p>
            <p>
                في هذا النوع يصبح عدد الحدفات الأرضية موازي لعدد حدفات النقش ومساوي لعدد خيوط السداء، وتكون اللحمة مغطاة تماما بالسداء ولا تظهر إلا عند البراسل، كما في شكل (18).
            </p>

            <figure class="my-6">
                <img src="{{ asset('images/technique/fig-18.jpg') }}" class="w-full md:w-1/2 mx-auto h-auto object-cover rounded-2xl shadow-md" alt="شكل 18 - تصميم النقشة الزائدة من اللحمة على ورق المربعات">
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (18) يوضح تصميم النقشة الزائدة من اللحمة على ورق المربعات
                </figcaption>
            </figure>

            <p class="mt-3 font-semibold text-gray-700">اللحمة الزائدة ذات وجه لحمة (Weft Faced Overshot):</p>
            <p>
                يكون السداء في هذا النوع مغطى بالكامل على كلا جوانب النسيج، كما يسمح بالتبادل الواضح للمساحات المتجاورة من اللون لعدم وجود تداخل بين اللحمة والسداء.
            </p>

            <p class="mt-3 font-semibold text-gray-700">اللحمة الزائدة باستخدام السداء الحر (Tide Overshot):</p>
            <p>
                يعتمد هذا النوع على لقي جزء من خيوط السداء في المشط فقط دون الدرأه فتصبح هذه الخيوط حرة وثابته وسط النفس.
            </p>
            <span class="citation">(Sullivan, D., 1996, p138)</span>

            <h4 class="font-bold text-gray-800 text-lg mt-6">2 - اللحمة الزائدة "الحقيقية":</h4>
            <p class="mt-3 font-semibold text-gray-700">لحمة زائدة متقطعة:</p>
            <p>
                يستخدم هذا النوع في أجزاء التصميم غير المتصلة ببعضها في اتجاه السداء، لذا يتم إعادة ترتيب اللحمات في الاجزاء التي لا تحتوي على النقشة، وذلك باستعمال لحمة الأرضية فقط، تعتبر هذه الطريقة مفيدة في الحصول على الزخرفة دون الزيادة الى تكاليف الإنتاج، وشكل (19) يوضح تصميم اللحمة الزائدة المتقطعة.
            </p>

            <figure class="my-6">
                <img src="{{ asset('images/technique/fig-19.jpg') }}" class="w-full md:w-1/3 mx-auto h-auto object-cover rounded-2xl shadow-md" alt="شكل 19 - تصميم اللحمة الزائدة المتقطعة">
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (19) يوضح تصميم اللحمة الزائدة المتقطعة<br>
                    <span dir="ltr">(Grosicki, Z., 2014, p13)</span>
                </figcaption>
            </figure>

            <p class="mt-3 font-semibold text-gray-700">لحمة زائدة مستمرة:</p>
            <p>
                تستخدم هذه الطريقة إذا كان التصميم متصل ببعضه البعض في اتجاه السداء.
            </p>

            <p class="mt-3 font-semibold text-gray-700">لحمة زائدة بلون مستمر وآخر متقطع:</p>
            <p>
                يستخدم في هذا النوع اذا كان هناك لحمة مستمرة وأخرى متقطعة، كما في شكل (20) وشكل (21).
            </p>
            <span class="citation">(غادة محمد الصياد، 2013، ص 66)</span>

            <div class="flex flex-col md:flex-row gap-6 my-8">
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-20.jpg') }}" class="w-full h-auto object-cover rounded-2xl shadow-md" alt="شكل 20 - لحمة زائدة مستمرة بلون واحد">
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (20) يوضح تصميم لحمة زائدة مستمرة بلون واحد بترتيب 1 أرضية، 1 نقش.
                    </figcaption>
                </figure>
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-21a.jpg') }}" class="w-full h-auto object-cover rounded-2xl shadow-md" alt="شكل 21 - لحمة زائدة بلونين مستمرين">
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (21) يوضح تصميم لحمة زائدة بلونين مستمرين بترتيب 1: أرضية نقش أ، 1: لون ب
                    </figcaption>
                </figure>
            </div>
        </section>

        <section class="mb-14">
            <h3 id="sec-10" class="scroll-mt-40 lg:scroll-mt-32 text-xl font-bold text-gray-700 mb-3">تحبيس النقوش الزائدة من اللحمة:</h3>
            <p>
                يبين (أنور عبد الحميد، 2009، ص 279) ان هذه الطريقة لا تستخدم في مثل هذا النوع من النقشات الصغيرة، وذلك بسبب صغر مسافة التشييف، اما النقشات الكبيرة فتستخدم عليها هذه الطريقة سواء في وجه او ظهر القماش على ابعاد تتناسب مع حجم الرسم حتى لا تكون عرضة للقطع، مع اختيار التحبيسات التي تتناسب مع الشكل، مع الحرص على عدم تأثر علامات التحبيس في مظهر القماش.
            </p>

            <p class="mt-3 font-semibold text-gray-700">اللحمة الزائدة المقصوصة:</p>
            <p>
                تتم هذه الطريقة بتحبيس حدود الشكل من الجوانب ووضع صفين او أكثر من نسيج السادة 1/1 حول النقشة او نسيج مبردي، لتثبيت لحمات النقشة في القماش، كما يمكن حتى فصل اللحمات الشائفة في ظهر القماش اثناء التجهيز، وتستخدم أيضًا لتقليل وزن الاقمشة بقدر المستطاع.
            </p>
            <span class="citation">(مصطفى زاهر، 1997، ص 143)</span>

            <h4 class="font-bold text-gray-800 text-lg mt-6">3 - نسيج السداء الزائد "الحقيقية":</h4>
            <p>
                ذكر (حسن طه، ومها الشيمي، 2016، ص 401) بأنه يتم تنفيذ نسيج السداء الزائد بشكل عام عن طريق إضافة خيوط على سطح المنسوج باتجاه السداء، بحيث ينسج بتقنيات مختلفة وتترك خلفها تشييفات على سطح القماش كما في صورة (60،61).
            </p>

            <figure class="my-8">
                <img src="{{ asset('images/technique/img-60-61.jpg') }}" class="w-full md:w-3/4 mx-auto h-auto object-cover rounded-2xl shadow-md" alt="صورة 60-61 - شكل النقشة الزائدة من السداء بعد تنفيذه">
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (60،61) توضح شكل النقشة الزائدة من السداء بعد تنفيذه لقماش نهائي<br>
                    <span dir="ltr">(https://cargocollective.com)</span>
                </figcaption>
            </figure>

            <p>
                و تميزت انسجة السداء الحقيقية بالنقوش الظاهرة على الاقمشة المنسوجة الناتجة عن استعمال خيوط زائدة بين خيوط السداء الاصلية (الأرضية)، حيث تتركب من لحمة واحدة ونوعين من السداء او اكثر حيث يتعاشق سداء الأرضية مع اللحمة لتكوين المنسوج الأصلي، باستخدام النسيج السادة 1/1 او المبرد او الاطلس.
            </p>
            <span class="citation" dir="ltr">(Chetwynd, H., 1988, p60-64)، (Grosicki, Z., 2014, p13)</span>
        </section>

        <section class="mb-14">
            <h3 id="sec-11" class="scroll-mt-40 lg:scroll-mt-32 text-xl font-bold text-gray-700 mb-3">تصميمات اللحمة الزائدة على ورق المربعات:</h3>
            <p>
                يعتمد فهم التصميم النسجي على مصطلحات عديدة أساسية لفهم العملية التنفيذية والتصميمية للنسيج وهي كما يلي:
            </p>
            <p>
                <strong>القوالب:</strong> تطلق كلمة "قالب" على المناطق المميزة في أي تصميم من تصميمات النقشة الزائدة التي تتحرك او تعمل نفس الحركة، يوضح القوالب في التصميم النقشة الزائدة.
            </p>

            <div class="flex flex-col md:flex-row gap-6 my-8">
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-22.jpg') }}" class="w-full h-auto object-cover rounded-2xl shadow-md" alt="شكل 22">
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (22) تصميم النقشة الزائدة على ورق المربعات
                    </figcaption>
                </figure>
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-23.jpg') }}" class="w-full h-auto object-cover rounded-2xl shadow-md" alt="شكل 23">
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (23) تصميم تنفيذي للنقشة الزائدة
                    </figcaption>
                </figure>
            </div>

            <div class="flex flex-col md:flex-row gap-6 my-8">
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-24.jpg') }}" class="w-full h-auto object-cover rounded-2xl shadow-md" alt="شكل 24">
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (24)
                    </figcaption>
                </figure>
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-25.jpg') }}" class="w-full h-auto object-cover rounded-2xl shadow-md" alt="شكل 25">
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (25)
                    </figcaption>
                </figure>
            </div>
        </section>

            </div>

        </div>
    </section>
@endsection

@push('scripts')
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
@endpush
