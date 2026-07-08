@extends('layouts.app')

@section('title', $page->title_ar ?? 'تقنية النقشة الزائدة')

@push('styles')
<style>
    html { scroll-behavior: smooth; }
    .page-placeholder__card { opacity: 0; transform: translateY(20px); animation: fadeInUp 0.8s ease-out forwards; }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<main dir="rtl" class="bg-gray-50/50 min-h-screen pb-20">

    <!-- Hero Banner -->
    <section class="hidden md:block py-8 lg:py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl group min-h-[400px] bg-gray-900">
                @if($page->hero_image)
                    <img src="{{ $page->hero_image }}" alt="صورة {{ $page->title_ar }}" class="absolute inset-0 w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-700 ease-in-out" style="filter:sepia(0.2)">
                @else
                    <img src="{{ asset('images/technique/hero.jpg') }}" alt="Hero Image" class="absolute inset-0 w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-700 ease-in-out" style="filter:sepia(0.2)">
                @endif
                
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
                
                <div class="absolute bottom-0 inset-x-0 p-10 lg:p-16 flex flex-col justify-end transform transition duration-500">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-medium mb-6 w-fit">
                        <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                        قسم التقنيات
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight drop-shadow-lg font-amiri">
                        {{ $page->title_ar ?? 'تقنية النقشة الزائدة' }}
                    </h1>
                    @if($page->subtitle_ar)
                        <p class="text-xl text-gray-200 max-w-2xl font-light leading-relaxed drop-shadow-md border-r-4 border-indigo-400 pr-4">
                            {{ $page->subtitle_ar }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Header -->
    <section class="md:hidden bg-white border-b border-gray-100 pt-8 pb-6 px-4">
        <div class="container mx-auto">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold mb-4">
                قسم التقنيات
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-3 font-amiri">{{ $page->title_ar ?? 'تقنية النقشة الزائدة' }}</h1>
            @if($page->subtitle_ar)
                <p class="text-gray-600 text-base leading-relaxed">{{ $page->subtitle_ar }}</p>
            @endif
        </div>
    </section>

    <!-- Content Area -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl pt-10">
        <div class="flex flex-col xl:flex-row gap-10 lg:gap-16">
            
            <!-- Table of Contents Sidebar -->
            <aside class="w-full xl:w-1/3 xl:flex-shrink-0">
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 sticky top-24 mb-10 xl:mb-0">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
        <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
        </span>
        محتويات الصفحة
    </h3>
    <ul class="space-y-4 text-gray-600 font-medium">
        <li>
            <a href="#section-1" class="flex items-center gap-3 hover:text-indigo-600 transition-colors group">
                <span class="w-6 h-6 rounded-full bg-gray-50 text-gray-400 flex items-center justify-center text-sm group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                    1
                </span>
                مقدمة
            </a>
        </li>
        <li>
            <a href="#section-2" class="flex items-center gap-3 hover:text-indigo-600 transition-colors group">
                <span class="w-6 h-6 rounded-full bg-gray-50 text-gray-400 flex items-center justify-center text-sm group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                    2
                </span>
                مفهوم التركيب النسجي 
            </a>
        </li>
        <li>
            <a href="#section-3" class="flex items-center gap-3 hover:text-indigo-600 transition-colors group">
                <span class="w-6 h-6 rounded-full bg-gray-50 text-gray-400 flex items-center justify-center text-sm group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                    3
                </span>
                النقشة الزائدة في العصر القبطي
            </a>
        </li>
        <li>
            <a href="#section-4" class="flex items-center gap-3 hover:text-indigo-600 transition-colors group">
                <span class="w-6 h-6 rounded-full bg-gray-50 text-gray-400 flex items-center justify-center text-sm group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                    4
                </span>
                الأساليب التقنية لنسيج النقشة الزائدة
            </a>
        </li>
        <li>
            <a href="#section-5" class="flex items-center gap-3 hover:text-indigo-600 transition-colors group">
                <span class="w-6 h-6 rounded-full bg-gray-50 text-gray-400 flex items-center justify-center text-sm group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                    5
                </span>
                ثانياً الأساليب التقليدية والحقيقية
            </a>
        </li>
        <li>
            <a href="#section-6" class="flex items-center gap-3 hover:text-indigo-600 transition-colors group">
                <span class="w-6 h-6 rounded-full bg-gray-50 text-gray-400 flex items-center justify-center text-sm group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                    6
                </span>
                تحبيس النقوش الزائدة من اللحمة
            </a>
        </li>
        <li>
            <a href="#section-7" class="flex items-center gap-3 hover:text-indigo-600 transition-colors group">
                <span class="w-6 h-6 rounded-full bg-gray-50 text-gray-400 flex items-center justify-center text-sm group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                    7
                </span>
                طرق توقيع تصميمات النقشة الزائدة على ورق المربعات
            </a>
        </li></ul></div>
            </aside>

            <!-- Main Article Content -->
            <article class="w-full xl:w-2/3 bg-white p-6 md:p-10 lg:p-14 rounded-2xl shadow-sm border border-gray-100">
                <div class="prose prose-lg prose-indigo max-w-none">
                    <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-3">مقدمة:</h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                عرفت الصناعة النسيجية قبل التاريخ منذ العصور القديمة حيث ان الحضارات القديمة لا تخلو من آثار تدل على أن صناعة النسيج كانت تزاول على درجات متفاوتة، كما أثبتت لنا النقوش والآثار الموجودة على جدران المقابر والمعابد أن صناعة المنسوجات كانت من الصناعات اليدوية التي مارسها الانسان منذ أمد بعيد.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(أنصاف نصر، وكوثر الزغبي، 1981، ص 291)</span>

            <figure class="my-8">
                <img src="{{ asset('images/technique/img-52.jpg') }}" alt="صورة 52" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (52) نسيج التابستري<br>
                    <span dir="ltr">(Stauffer, A., 1995, P.32)</span>
                </figcaption>
            </figure>

            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                تنوعت التراكيب النسجية التي عرفت منذ العصور القديمة وكان الهدف الأساسي دائما الحصول على منسوج قوي وجميل، وعلى زخارف نسجية تميز صناع الأقمشة ومصمميها، كما أن العصور القديمة قد استعملت طرق مختلفة للحصول على الزخارف منها طريقة القباطي وهو النسيج المعروف بـ (التبستري (10)) يظهر في صورة (52) ، وطريقة النسيج الوبري، وطريقة النقشة الزائدة، بهذه الطرق تتداخل التراكيب النسجية اذ يمكن الحصول على عدد لا يحصى من النماذج المختلفة والمتنوعة.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(سعد كامل، 1976، ص 53)</span>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                يعتبر نسيج النقشة الزائدة "التقليدية - والحقيقية" أحد التقنيات والطرق المستخدمة في تصميم وزخرفة المنسوجات منذ القدم، وقد قسمت القطع التي نسجت زخارفها بطريقة اللحمة الزائدة التقليدية من ناحية المواد الخام إلى مجموعتين : (مجموعة قطعها من الكتان الغير ملون والخيوط المستعملة في اللحمة التقليدية أكثر بياضًا وأسمك من أرضية النسيج ذلك حتى تظهر على سطح النسيج وهذه زخارفها مكونة عادة من زخارف هندسية بسيطة ومعظم الأحيان محصورة في مربعات ومستطيلات، ومجموعة تتكون أرضيتها وزخارفها من الصوف وتمتاز عن القطع الأخرى بأنها نسيج سميك ذات ألوان باهته).
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(سعاد ماهر، 1977، 66-68)</span>

            <div class="footnote">
                (10) تابستري : نوع من أنواع الزخرفة المنسوجة الذي ينفذ على الأنوال اليدوية التي عرفت بمصر قديما، يعرفه معجم المصطلحات النسجية بأنه نسيج ذو طابع زخرفي، يتم نسجه بنسيج سادة 1/1 ، فيه تغطي اللحمات خيوط السداء، وتظهر على شكل تضليعات طولية.<br>
                (نيرفانا عبد الباقي، 2023، ص 524)
            </div>
        </section>

<section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-3">مفهوم التركيب النسجي :</h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                طريقة يتم بواسطتها تعاشق او تشابك كلا من خيوط السداء واللحمة معا لتكوين المنسوج، وتعتبر التراكيب النسجيه أحد أهم العوامل الرئيسية في التركيب البنائي التي يعتمد عليها المصمم في التوصل الى خواص المنسوج المطلوب تحقيقها حيث انها تقوم بدور هام في تحديد جودة المنتج النهائي ومدى تناسبه لأدائه الوظيفي، وشكل (14) يوضح تعاشق الخيوط في التركيب النسجي.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(فتحي السماديسي، 2018، ص2)</span>

            <figure class="my-8">
                <img src="{{ asset('images/technique/fig-14.jpg') }}" alt="شكل 14" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (14) تعاشق الخيوط في التركيب النسجي<br>
                    <span dir="ltr">(https://areq.net)</span>
                </figcaption>
            </figure>

            <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-3">مفهوم النقشة الزائدة:</h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                نسيج من منسوجات النسيج السادة مضاف لها خيوط زائدة في السداء واللحمة على سطح المنسوج مكونة زخرفة، اذ تتخلل الخيوط الأرضية للمنسوج الأصلي وغالبا ما تكون هذه الأرضية نسيج سادة، كما في صورة (53).
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(محمد الشربيني، 1972، ص 32)</span>

            <figure class="my-8">
                <img src="{{ asset('images/technique/img-53.jpg') }}" alt="صورة 53" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (53) قطعة اثرية لاسلوب نسيج النقشة الزائدة<br>
                    (منال الصالح، 2014، ص 34)
                </figcaption>
            </figure>

            <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-3">التطور التاريخي لنسيج النقشة الزائدة:</h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                تطورت النقشة الزائدة عبر العصور القديمة، حيث تنوعت في كل عصر من العصور، واستخدمت في صناعة وتنفيذ نسيج النقشة الزائدة مواد خام اذ يقع في المركز الأول الكتان يليه الصوف في المركز الثاني، وجاء في المركز الثالث الحرير، اما القطن فقد ورد ذكره في المصادر القديمة.
            </p>

            <h3 class="text-2xl font-bold text-indigo-800 mb-4 mt-8">النقشة الزائدة في العصر الفرعوني:</h3>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                ينفذ النسيج داخل المصانع الملكية التي توفر حاجات الملك وبلاطه، وكانت صناعة المعابد تنافس الصناعة الملكية، حيث ان لكل معبد مصنعه الخاص الذي يُعد وينتج حاجات الآلهة والكهنه، كما توفرت العديد من الخامات التي أتاحت الفرصة الكبيرة في عمل توليفات جذابة ظهرت في العديد من القطع النسجية الاثرية الموجودة في المتحف المصري بالقاهرة والتي عثر عليها في المقابر، وقد قسم النساجين في العصر الفرعوني الزخرفة النسجية الى توليف خيوط الكتان الخام والكتان الملون، وتوليف خيوط الصوف الملون، والكتان الخام، توليف عن طريق استخدام أساليب نسجية مختلفة عن بعضها البعض.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(سعاد ماهر، 1986، ص 64)</span>

            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                تظهر صورة (54) نسيج النقشة الزائدة في العصر الفرعوني، ويوضح التحليل الوصفي لها، الخامات المستخدمة خيوط كتان خام، وخيوط صوف ملون، والصباغة والألوان المستخدمة متملثة باللون الأخضر، والاحمر، وتصنيع نسيج النقشة الزائدة يُظهر الزخرفة بخيوط الصوف الملون واذ تمثلت الوانه باللونين "الأخضر، والأحمر"، وظهرت خيوط الصوف الخضراء منسوجة في جسم الطائر الذي يبدو في وضع السكون، كما نسجت خيوط الصوف الحمراء في أرجله ومنقاره وجزء من أجنحته، بالإضافة الى أوراق زهرة اللوتس نسجت بخيوط الصوف الأحمر وقاعدتها بخيوط الصوف الخضراء وفي نهاية القطعة النسجية يظهر شكل يشبه ورقة من الشجر منسوجة بخيوط الصوف الخضراء، وفروعها من خيوط الكتان الخام، وظهر الانسياب والانسجام في تناسق الوان خيوط الصوف الملون وخيوط الكتان الخام ، اذ تم توزيع خيوط الصوف في جميع أجزاء القطعة باتزان تام، كما أعطى الاتزان الغير متماثل إحساس مشوق في القطعة.
            </p>
            
            <figure class="my-8">
                <img src="{{ asset('images/technique/img-54.jpg') }}" alt="صورة 54" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (54) توضح جزء من رداء يرجع للعصر الفرعوني<br>
                    (كفاية احمد، وآخرون، 2001، ص 163)
                </figcaption>
            </figure>
        </section>

<section class="mb-12">
            <h3 class="text-2xl font-bold text-indigo-800 mb-4 mt-8">النقشة الزائدة في العصر القبطي</h3>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                يعتبر فن النسيج به فناً شعبياً انتشر في جميع المدن، كانت المنسوجات الكتانية تصنع في مدن مصر السفلى نظراً لملاءمتها للمناخ بينما كانت المنسوجات الصوفية تنتج في مدن مصر العليا، إذ يعتبر الكتان والصوف من الخامات الأساسية في معظم المنسوجات القبطية، كما كان من النادر استخدام الحرير، حيث اعتبره رجال الدين منافياً لمبادئ الرجولة، ورغم توافر القطن إلا أنه لم يثبت استخدامه في صناعة النسيج.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(سعاد ماهر حشمت مسیحه، 1957، ص 20)</span>

            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                يعد اول من ابتكر طريقة النسيج بالنقشة الزائدة هم الأقباط المصريين، يوجد بعض القطع في المتحف المصري والمتحف القبطي قد استعمل فيها الخيوط الكتانية المبيضة "البيضاء"، كلحمة زائدة زخرفية على مسافات منتظمة، واستخدم الصوف المصبوغ باللون الكحلي أو الأحمر على الأرضية، وقد نفذت هذه القطع جمعها على هيئة أشرطة منفصلة تخاط بالأقمشة والقمصان من الجانبين على الامام او من الامام والخلف كما كان متبع في اردية الفرسان وقسم أسلوب الزخرفة عندهم الى توليف بين أكثر من اسلوب من الاساليب النسجية، أيضًا توليف خيوط الكتان الخام والكتان الملون او المبيض، بالإضافة الى توليف خيوط الكتان الخام والصوف الملون.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(مصطفى محمد، 1969، ص 30)</span>

            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                يظهر أسلوب النقشة الزائدة عند الاقباط في صورة (55) اذ يوضح الوصف التحليلي لها، الخامات المستخدمة خيوط کتان خام وصوف ملون وتمثلت الألوان والصبغات باللون الأسود والاحمر والاخضر والبرتقالي، ظهر أسلوب النقشة الزائدة بنسج الزمار بخيوط الصوف الأسود لأنه يعتبر من عامة الشعب، يرتدي سترة على جسمه من خيوط الصوف الخضراء بها دوائر من الكتان الخام ويرتدي سروال أحمر به مجموعة من النقاط السوداء المنفذة من الصوف وباقي الجسم نسج من الصوف الأسود، كما برع الفنان في اظهار تفاصيل قدمه وساقه ووجهه بخطوط رفيعة، كما يوجد بالقطعة العديد من عناصر التصميم التي تم نسجها بخيوط الصوف الملون، وظهر الإيقاع اللوني في تباعد درجات الوان الخيوط، واستخدام اللون الأسود للزمار جعله يسحب الرؤية، كما ظهرت علاقة الكل بالجزء بالقطعة اذ ربط بين شخصية الزمار كجزء بباقي القطعة، وظهر بها اتزان غير متماثل في اختلاف نصفيها الأيمن عن الايسر، بالإضافة الى التناسق في توزيع نسب الكتل اللونية على جميع مسار القطعة اللونية.
            </p>

            <figure class="my-8">
                <img src="{{ asset('images/technique/img-55.jpg') }}" alt="صورة 55" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (55) جزء من ستارة ترجع للعصر القبطي<br>
                    <span dir="ltr">(https://egymonuments.gov.eg)</span>
                </figcaption>
            </figure>

            <h3 class="text-2xl font-bold text-indigo-800 mb-4 mt-8">النقشة الزائدة في العصر الإسلامي</h3>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                اذ تعد صناعة النسيج فيه موضع التقدير ومضرب الأمثال في الدقة والجمال، حيث تم الاستفادة من هذا التراث الفني وتشجيعه من العرب حتى ازدهرت صناعة النسيج في العالم الإسلامي عامة ومصر خاصة، وبلغت درجة عالية من الكمال والاتقان، وظهر فن النسيج في كسوة الكعبة التي يقدسها العرب قبل وبعد الإسلام، والذي أدى الى اهتمام المسلمين بالمنسوجات اذ أخضعوها للرقابة الحكومية.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(سعاد ماهر، 1977، ص 9)</span>

            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                وذكرت كفاية أحمد، وآخرون، 2001، ص (29) ان أساليب الزخرفة النسجية تنقسم لدى النساجين في العصر الإسلامي الى : "توليف خيوط الكتان الخام والملون وخيوط الذهب، وتوليف بين خيوط الكتان الخام والحرير الملون، بالإضافة الى توليف خيوط الكتان الخام وخيوط الصوف الملون، والتوليف بين خيوط الكتان الخام والقطن الملون، والتوليف بين الكتان الخام والملون".
            </p>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                ظهر ذلك في صورة (56)، اذ يبين التحليل الوصفي لها، الخامات المستخدمة بالكتان الخام والصوف الملون، وظهر اسلوب النقشة الزائدة في القطعة المنسوجة من الكتان الملون يوجد بها شريط عريض من الكتابة التي نسجت حروفها من الكتان الابيض تنص العبارة الموجودة عليها بـ "بركة من الله لعبد"، يحيط بها شريطين ضيقين زخرفيين من أعلى ومن أسفل منسوجين بأسلوب اللحمة الزائدة التقليدية، بالإضافة الى تحلل خيوط لحمتها ولم يتبقى منها الا جزء بسيط، ونسجت الأرضية بالصوف الملون "الباهت".
            </p>

            <figure class="my-8">
                <img src="{{ asset('images/technique/img-56.jpg') }}" alt="صورة 56" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (56) جزء من نسيج<br>
                    (سعاد ماهر، 1977، ص 276)
                </figcaption>
            </figure>
        </section>

<section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-3">الأساليب التقنية لنسيج النقشة الزائدة:</h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                تعتبر منسوجات النقشة الزائدة منسوجات عادية بسيطة مضافًا إليها خيوط زائدة التكوين الزخرفة أو التصميم، حيث تتخلل الخيوط الأرضية الاصلية للمنسوج بترتيب خاص مع ظهور تشييفها او حبسها وفق الرغبة على وجه القماش في أماكن خاصة حسب الزخرفة أو الأثير المطلوب.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(منال عبدالله الصالح، 2014، ص)</span>

            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                تتكون هذه المنسوجات من استخدام خيوط زائدة بالمنسوج الأصلي اما عن طريق اللحمة وتسمى نقشة زائدة من اللحمة او عن طريق السداء وتسمى خيوط زائدة من السداء، وتمتد الخيوط الزائدة على سطح المنسوج لتكوين النقش المطلوب اظهاره وتختفي في ظهر القماش بحيث يمكن سحبها الى الخارج دون ان يؤثر على متانة القماش.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(جمال عبد الحميد، وآخرون، 2021، ص 173)</span>

            <h3 class="text-2xl font-bold text-indigo-800 mb-4 mt-8">أولاً / أساليب لاتجاه النسيج :</h3>
            <ol class="list-decimal list-inside space-y-4 text-lg">
                <li>
                    <strong>نسيج النقشة الزائدة من السداء (Extra Warp) :</strong> الزائد بلون واحد او لونين في نفس النقشة كما في شكل (16) ، بحيث يكون خيط السداء للأرضية ثم خيط اسداء للنقش أو ترتيب خيطين سداء أرضية وخيط للنقش طبقًا لقطر الخيوط المستخدمة في سداء النقش الزائد، يظهر ذلك في صورة (57).
                    <span class="citation inline mr-2">(مصطفی زاهر، 1997، ص 139)</span>
                </li>
            </ol>

            <div class="flex flex-col md:flex-row gap-6 my-8">
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-16.jpg') }}" alt="شكل 16" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (16) يوضح تصميم النقشة الزائدة من السداء على ورق المربعات
                    </figcaption>
                </figure>
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/img-57.jpg') }}" alt="صورة 57" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                        صورة (57) نسيج النقشة الزائدة من السداء<br>
                        <span dir="ltr">https://textilelearner.net</span>
                    </figcaption>
                </figure>
            </div>

            <ol start="2" class="list-decimal list-inside space-y-4 text-lg">
                <li>
                    <strong>نسيج النقشة الزائدة من اللحمة (Extra Weft) :</strong> نسيج عادي يتم إضافة اليها لحمة زائدة تتخلل الحمة الاصلية بترتيب خاص وفق تصميم معين يتم تنفيذ نسيج النقشة الزائدة من اللحمة بطريقتين وهي كما يلي :
                </li>
            </ol>

            <h4 class="text-xl font-bold text-gray-700 mb-3 mt-6">الطريقة الأولى اللحمة الزائدة التقليدية (Immitation Extra Weft):</h4>
            <p class="pr-6">
                يذكر ( نبيل إبراهيم 2001 ، ص 13) للتنفيذ هذا النوع نحتاج الى سداء واحد ولحمة واحدة بحيث تشترك اللحمة الزائدة في تكوين أرضية النسيج فتصبح جزء من التركيب النسجي للمنسوج، ولو تم نزع اللحمة الزائدة ينتج تشييف لخيوط السداء وغالبا ماتكون الزخارف بلون الأرضية، كما في صورة (58)، وصورة (59).
            </p>

            <div class="flex flex-col md:flex-row gap-6 my-8">
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/img-58.jpg') }}" alt="صورة 58" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                        صورة (58) توضح أسلوب النقشة الزائدة من اللحمة بعد التنفيذ.<br>
                        <span dir="ltr">(https://creative-threads.co.uk)</span>
                    </figcaption>
                </figure>
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/img-59.jpg') }}" alt="صورة 59" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                        صورة (59) وسادة منسوجة بأسلوب اللحمة التقليدية<br>
                        (منال الصالح، 2014، ص 35)
                    </figcaption>
                </figure>
            </div>

            <h4 class="text-xl font-bold text-gray-700 mb-3 mt-6">الطريقة الثانية هي التي تعتبر الأكثر تطورًا اللحمة الزائدة الحقيقية (Extra Weft Fabrics):</h4>
            <p class="pr-6">
                زخارف ونقشات تظهر على سطح القماش بإستخدام حركة لحمات زائدة توضع بين اللحمات الأصلية للقماش يظهر ذلك في ومهمتها تقوم بعمل النقش على القماش دون أن تؤثر على التركيب الأصلي للقماش.
            </p>
            <span class="citation pr-6">(أسامة عز الدين، 2018، 283)</span>

            <ol start="3" class="list-decimal list-inside space-y-4 text-lg mt-6">
                <li>
                    <strong>نسيج النقشة الزائدة من كلا الاتجاهين (Extra Weft And Warp):</strong><br>
                    وضح (مصطفى زاهر، 1997، ص 143) أن من الممكن الجمع بين النوعين (النقشة الزائدة من السداء، والنقشة الزائدة من اللحمة في تصميم واحد ويلزم في هذه الحالة استخدام مطوتين سداء، واحدة لسداء الأرضية والأخرى لسداء النقشة، وشكل (17) يوضح تصميم النقشة الزائدة من كلا الاتجاهين.
                </li>
            </ol>

            <figure class="my-8">
                <img src="{{ asset('images/technique/fig-17.jpg') }}" alt="شكل 17" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (17) يوضح تصميم النقشة الزائدة من كلا الاتجاهين على ورق المربعات
                </figcaption>
            </figure>
        </section>

<section class="mb-12">
            <h3 class="text-2xl font-bold text-indigo-800 mb-4 mt-8">ثانياً الأساليب التقليدية والحقيقية:</h3>
            <h4 class="text-xl font-bold text-gray-700 mb-3 mt-6">1 - اللحمة الزائدة "التقليدية" :</h4>
            
            <p class="mt-3 font-semibold text-gray-700">اللحمة الزائدة ذات وجه سداء (Warp Faced Overshot):</p>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                في هذا النوع يصبح عدد الحدفات الأرضية موازي لعدد حدفات النقش ومساوي لعدد خيوط السداء، وتكون اللحمة مغطاة تماما بالسداء ولا تظهر إلا عند البراسل، كما في شكل (18).
            </p>

            <figure class="my-6">
                <img src="{{ asset('images/technique/fig-18.jpg') }}" alt="شكل 18" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (18) يوضح تصميم النقشة الزائدة من اللحمة على ورق المربعات
                </figcaption>
            </figure>

            <p class="mt-3 font-semibold text-gray-700">اللحمة الزائدة ذات وجه لحمة (Weft Faced Overshot):</p>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                يكون السداء في هذا النوع مغطى بالكامل على كلا جوانب النسيج، كما يسمح بالتبادل الواضح للمساحات المتجاورة من اللون لعدم وجود تداخل بين اللحمة والسداء.
            </p>

            <p class="mt-3 font-semibold text-gray-700">اللحمة الزائدة باستخدام السداء الحر (Tide Overshot):</p>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                يعتمد هذا النوع على لقي جزء من خيوط السداء في المشط فقط دون الدرأه فتصبح هذه الخيوط حرة وثابته وسط النفس.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(Sullivan, D., 1996, p138)</span>

            <h4 class="text-xl font-bold text-gray-700 mb-3 mt-6">2 - اللحمة الزائدة " الحقيقية" :</h4>
            <p class="mt-3 font-semibold text-gray-700">لحمة زائدة متقطعة:</p>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                يستخدم هذا النوع في أجزاء التصميم غير المتصلة ببعضها في اتجاه السداء، لذا يتم إعادة ترتيب اللحمات في الاجزاء التي لا تحتوي على النقشة، وذلك باستعمال لحمة الأرضية فقط"، تعتبر هذه الطريقة مفيدة في الحصول على الزخرفة دون الزيادة الى تكاليف الإنتاج، وشكل (19) يوضح تصميم اللحمة الزائدة المتقطعة.
            </p>

            <figure class="my-6">
                <img src="{{ asset('images/technique/fig-19.jpg') }}" alt="شكل 19" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (19) يوضح تصميم اللحمة الزائدة المتقطعة<br>
                    <span dir="ltr">(Grosicki, Z., 2014, p13)</span>
                </figcaption>
            </figure>

            <p class="mt-3 font-semibold text-gray-700">لحمة زائدة مستمرة:</p>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                تستخدم هذه الطريقة إذا كان التصميم متصل ببعضه البعض في اتجاه السداء.
            </p>

            <p class="mt-3 font-semibold text-gray-700">لحمة زائدة بلون مستمر وآخر متقطع:</p>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                يستخدم في هذا النوع اذا كان هناك لحمة مستمرة وأخرى متقطعة، كما في شكل (20) وشكل (21).
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(غادة محمد الصياد، 2013 ، ص 66)</span>

            <div class="flex flex-col md:flex-row gap-6 my-8">
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-20.jpg') }}" alt="شكل 20" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (20) يوضح تصميم لحمة زائدة مستمرة بلون واحد بترتيب 1 ارضية، 1 نقش.
                    </figcaption>
                </figure>
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-21a.jpg') }}" alt="شكل 21" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (21) يوضح تصميم لحمة زائدة بلونين مستمرين بترتيب 1: أرضية نقش أ، 1: لون ب
                    </figcaption>
                </figure>
            </div>
        </section>

<section class="mb-12">
            <h3 class="text-2xl font-bold text-indigo-800 mb-4 mt-8">تحبيس النقوش الزائدة من اللحمة</h3>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                يبين (أنور عبد الحميد، 2009، ص 279) ان هذه الطريقة لا تستخدم في مثل هذا النوع من النقشات الصغيرة، وذلك بسبب صغر مسافة التشييف، اما النقشات الكبيرة فتستخدم عليها هذه الطريقة سواء في وجه او ظهر القماش على ابعاد تتناسب مع حجم الرسم حتى لا تكون عرضة للقطع، مع اختيار التحبيسات التي تتناسب مع الشكل، مع الحرص على عدم تأثر علامات التحبيس في مظهر القماش.
            </p>

            <p class="mt-3 font-semibold text-gray-700">اللحمة الزائدة المقصوصة :</p>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                تتم هذه الطريقة بتحبيس حدود الشكل من الجوانب ووضع صفين او أكثر من نسيج السادة 1/1 حول النقشة او نسيج مبردي، لتثبيت لحمات النقشة في القماش، كما يمكن حتى فصل اللحمات الشائفة في ظهر القماش اثناء التجهيز، وتستخدم أيضًا لتقليل وزن الاقمشة بقدر المستطاع، وتجنب انتزاع الخيوط الزائدة بالمنسوج، بسبب اشتباكها مع أجزاء صلبة عند الاستعمال.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(مصطفى زاهر، 1997، ص 143)</span>

            <h4 class="text-xl font-bold text-gray-700 mb-3 mt-6">3 - نسيج السداء الزائد "الحقيقية" :</h4>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                ذكر (حسن طه، ومها الشيمي، 2016، ص 401) بأنه يتم تنفيذ نسيج السداء الزائد بشكل عام عن طريق إضافة خيوط على سطح المنسوج باتجاه السداء، بحيث ينسج بتقنيات مختلفة وتترك خلفها تشييفات على سطح القماش كما في صورة (60،61).
            </p>

            <figure class="my-8">
                <img src="{{ asset('images/technique/img-60-61.jpg') }}" alt="صورة 60،61" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (60،61) توضح شكل النقشة الزائدة من السداء بعد تنفيذه لقماش نهائي<br>
                    <span dir="ltr">(https://cargocollective.com)</span>
                </figcaption>
            </figure>

            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                و تميزت انسجة السداء الحقيقية بالنقوش الظاهرة على الاقمشة المنسوجة الناتجة عن استعمال خيوط زائدة بين خيوط السداء الاصلية (الأرضية)، حيث تتركب من لحمة واحدة ونوعين من السداء او اكثر حيث يتعاشق سداء الأرضية مع اللحمة لتكوين المنسوج الأصلي، باستخدام النسيج السادة 1/1 او المبرد او الاطلس، اما السداء الخاص بالنقشة الزائدة الحقيقية يتخلله خيوط السداء الأصلي بترتيب خاص فيظهر شائفًا او محبسًا على وجه المنسوج في أماكن ظهور النقش المطلوبة، كما ان السداء الزائد لا يشترك في التركيب الأساسي للمنسوج اذ نلاحظ انه اذا سحبت أي فتلة منه لا تؤثر على التركيب النسجي الأصلي حيث تظهر الأرضية دون نقص، لذلك اطلق على هذه المنسوجات اسم الانسجة ذات السداء الزائد الحقيقية او المستمرة او المتقطعة.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6" dir="ltr">(Chetwynd, H., 1988, p60-64)، (Grosicki, Z., 2014, p13)</span>

            <p class="mt-3 font-semibold text-gray-700">أنسجة السداء الزائد المستمرة:</p>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                تعتبر النقوش الزائدة من السداء مستمرة بعرض المنسوج إذا كانت أجزاء التصميم متصلة بعضها ببعض في اتجاه اللحمة.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(اماني شاكر، ولمياء صافي، 2011، ص 1772)</span>

            <p class="mt-3 font-semibold text-gray-700">أنسجة السداء الزائد المتقطعة:</p>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                تعتبر النقوش الزائدة من السداء تصميمات متقطعة في عرض المنسوج اذا كانت أجزاء النقشات غير متصلة مع بعضها في اتجاه اللحمة، يتم توزيع السداء الزائد في الأماكن التي تحتوي على أجزاء من النقش يتخللها خيوط سداء حسب الترتيب، ونلتفت الى الأماكن التي لا تحتوي على نقش (الأرضية) اذ يتم تطريح ولقي خيوط سداء الاصلية بعرض القماش دون انقطاع حتى يمكن الحصول على تركيب نسجي سادة 1/1 او مبرد او اطلس او أي تركيب منتظم بصرف النظر عن وجود بعض خيوط السداء الزائد والتي لو سحبت من النسيج كان التركيب النسجي مكتملا دون نقص.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(محمد جمل، حامد عامر، 2002، ص 46)</span>

            <h3 class="text-2xl font-bold text-indigo-800 mb-4 mt-8">تصميمات اللحمة الزائدة على ورق المربعات</h3>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                يعتمد فهم التصميم النسجي على مصطلحات عديدة أساسية لفهم العملية التنفيذية والتصميمية للنسيج وهي كما يلي:
            </p>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                <strong>القوالب :</strong> تطلق كلمة "قالب" على المناطق المميزة في أي تصميم من تصميمات النقشة الزائدة التي تتحرك او تعمل نفس الحركة، يوضح القوالب في التصميم النقشة الزائدة.
            </p>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                <strong>التوازن :</strong> تنتج الكثير من تصميمات النقشة الزائدة متناظرة حيث تتكرر متتالية من اللقي ونظام الادخال أوتوماتيكيا وهذا التناظر يتكرر بشكل آلي يسارًا ويمينا ولأسفل ولأعلى، وبناء على ذلك فإن لكل تكرار للتصميم مقاطع موازية، كما في شكل (21).
            </p>

            <figure class="my-8">
                <img src="{{ asset('images/technique/fig-21a.jpg') }}" alt="شكل 21" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (21) يوضح القوالب ويوضح التوازن الذي ينتج من تصميمات النقشة الزائدة<br>
                    <span dir="ltr">(Sullivan, D., 1996, P.10)</span>
                </figcaption>
            </figure>

            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                <strong>التكرارات:</strong> تظهر علامة (3) بالقرب من نظام ادخال اللحمات ونظام اللقي، وتشير الى ان هذا الجزء سيتم تكراره ثلاث مرات وقد يكون التكرار أكثر أو أقل حسب الرقم المدون بجوار علامة الـ.
            </p>
            <span class="text-indigo-600/80 text-sm block mt-[-1rem] mb-6">(سامية الشيخ، وحنان العمودي، 2014، ص67)</span>

            <p class="text-gray-700 leading-relaxed mb-6 text-lg text-justify">
                ويتميز مظهر الأجزاء المنقوشة بثلاث تأثيرات في الاقمشة وهي واضحة على سطح النسيج كما يلي:<br>
                (1) أجزاء داكنة أو ملونة تمثل النقش على السطح وفقا للتصميم.<br>
                (2) أجزاء فاتحة أو بيضاء تمثل أرضية القماش.<br>
                (3) أجزاء مظللة او نصف مظللة تمثل المزج من لحمات النقش تخلل الحمات الأرضية، وتظهر بين جزئين نقش او أرضية او بين أجزاء نقش وارضية، كما في شكل (22) التصميم على ورق المربعات، وشكل (23) يوضح التصميم بعد التنفيذ، والأجزاء المظللة والداكنة والفاتحة.
            </p>

            <div class="flex flex-col md:flex-row gap-6 my-8">
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-22.jpg') }}" alt="شكل 22" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (22) يوضح التصميم على ورق المربعات<br>
                        <span dir="ltr">(https://4.bp.blogspot.com)</span>
                    </figcaption>
                </figure>
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-23.jpg') }}" alt="شكل 23" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="absolute right-4 top-1/2 text-xs text-white bg-gray-800 bg-opacity-70 px-2 py-1 rounded hidden md:block">مناطق فاتحة</div>
                        <div class="absolute right-4 bottom-10 text-xs text-white bg-gray-800 bg-opacity-70 px-2 py-1 rounded hidden md:block">مناطق مظللة</div>
                    </div>
                    <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (23) يوضح التصميم بعد التنفيذ والأجزاء المظللة والداكنة والفاتحة<br>
                        <span dir="ltr">(Regensteiner, E., 1986, p.136)</span>
                    </figcaption>
                </figure>
            </div>
        </section>

<section class="mb-12">
            <h3 class="text-2xl font-bold text-indigo-800 mb-4 mt-8">طرق توقيع تصميمات النقشة الزائدة على ورق المربعات</h3>
            <ol class="list-decimal list-inside space-y-3 text-lg">
                <li>عمل تكرار واحد من النسيج المراد استعماله كأرضية للقماش، كما في شكل (24).</li>
                <li>رسم التصميم المراد تنفيذه من النقشة الزائدة على ورق المربعات مع تحبيس الأجزاء الشائفة على القماش.</li>
                <li>تحديد الصفوف الافقية الخاصة بالنقشة الزائدة بحسب الترتيب المطلوب استعماله.</li>
                <li>توضع الحمات الأرضية في الأماكن المخصصة بها، وتترك أماكن اللحمات الزائدة، مع ملاحظة اتصال نسيج الأرضية ببعضه كما لو كانت اللحمات الزائدة غير موجودة، كما في شكل (25).</li>
                <li>توضع النقشة الزائدة على الصفوف الافقية الخاصة بها ايضًا كما هي موجودة في الشكل الأصلي بحسب ترتيبها في الرسم والشكل الناتج.</li>
            </ol>
            <span class="citation mt-4 block">(حنان البديوي، 2000، ص 205)</span>

            <div class="flex flex-col md:flex-row gap-6 my-8">
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-24.jpg') }}" alt="شكل 24" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (24) يوضح مبرد أساسي 2/2
                    </figcaption>
                </figure>
                <figure class="flex-1">
                    <img src="{{ asset('images/technique/fig-25.jpg') }}" alt="شكل 25" class="w-full h-auto object-cover rounded shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <figcaption class="text-center mt-3 text-sm text-gray-500 font-medium" class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (25) يبين توقيع اللحمة الزائدة على ورق المربعات
                    </figcaption>
                </figure>
            </div>
        </section>


                </div>
            </article>

        </div>
    </div>
</main>
@endsection
