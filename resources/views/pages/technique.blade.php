@extends('layouts.premium', ['pageTitle' => $page->title_ar, 'backRoute' => route('home')])

@section('title', $page->title_ar . ' - رونق')

@section('content')
    <!-- Mobile-only title -->
    <div class="md:hidden container mx-auto px-4 py-6 text-center">
        <div class="inline-flex items-center justify-center gap-2 mb-2">
            <span class="h-px w-6 bg-morris-indigo"></span>
            <span class="text-morris-indigo font-magic text-lg">تقنية النقشة الزائدة</span>
            <span class="h-px w-6 bg-morris-indigo"></span>
        </div>
        <h1 class="font-brand text-4xl text-morris-primary font-bold drop-shadow-sm">{{ $page->title_ar }}</h1>
    </div>

    <!-- Hero Banner (hidden on mobile) -->
    <section class="hidden md:block py-8 lg:py-10">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="relative rounded-3xl lg:rounded-[2.5rem] bg-morris-primary overflow-hidden shadow-2xl flex items-center justify-between border border-morris-indigo/30 p-8 lg:p-12">
                <div class="absolute inset-0 opacity-[0.04]" style="background-image:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23F8F5F0\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                <div class="absolute inset-3 border border-morris-cream/20 rounded-2xl lg:rounded-[2rem] pointer-events-none"></div>

                <div class="relative z-10 w-3/5 lg:w-2/3 text-right pr-2 lg:pr-4">
                    <div class="inline-flex items-center gap-3 mb-3 lg:mb-4">
                        <span class="h-[2px] w-8 bg-morris-indigo rounded-full"></span>
                        <span class="font-magic text-morris-cream/90 text-xl lg:text-2xl">تقنية النقشة الزائدة</span>
                    </div>
                    <h1 class="font-brand text-4xl lg:text-5xl text-morris-cream mb-4 lg:mb-6 leading-tight drop-shadow-md">{{ $page->title_ar }}</h1>
                    <p class="text-base lg:text-xl text-morris-cream/80 leading-relaxed font-light max-w-2xl">{{ $page->intro_ar }}</p>
                </div>

                <div class="relative z-10 w-2/5 lg:w-1/3 flex justify-end pl-2 lg:pl-4">
                    <div class="relative w-40 h-56 lg:w-56 lg:h-72 rounded-t-[4rem] rounded-b-xl overflow-hidden border-4 border-morris-indigo/30 shadow-portrait bg-morris-primary/50 group">
                        @if($page->hero_image)
                            <img src="{{ $page->hero_image }}" alt="صورة {{ $page->title_ar }}" class="absolute inset-0 w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-700 ease-in-out" style="filter:sepia(0.2)">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-morris-cream/40">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-morris-primary/60 via-transparent to-transparent opacity-80"></div>
                        <div class="absolute inset-2 border border-morris-indigo/40 rounded-t-[3.5rem] rounded-b-lg pointer-events-none"></div>
                        <div class="absolute bottom-3 w-full text-center">
                            <span class="font-magic text-sm lg:text-base text-morris-cream drop-shadow-md">تقنية نسيج عريقة</span>
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
                            <div class="bg-white/80 rounded-full p-1 shadow-sm backdrop-blur-sm -ml-1 text-morris-indigo">
                                <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </div>
                        </div>
                        <nav id="toc" class="flex lg:flex-col overflow-x-auto lg:overflow-visible no-scrollbar gap-1 snap-x font-semibold relative">
                        </nav>
                    </div>
                </div>
            </aside>

            <!-- Article Content -->
            <div class="w-full lg:w-3/4 article-content bg-white/60 p-6 sm:p-8 lg:p-12 rounded-3xl shadow-sm border border-morris-border/50">

        <section class="mb-14">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-r-4 border-green-500 pr-3">اولا / الاستدامة:</h2>
            <h3 class="text-xl font-bold text-gray-700 mb-3">مقدمة :</h3>
            <span class="citation">(Minh, N., & Ngan, H. 2021, P.27)</span>
            <p>
                تلعب الاستدامة دورا حيويًا في معالجة المنسوجات حيث أن متطلبات اليوم هي انتاج سلع صديقة للبيئة، لديها القدرة على خدمة العميل والبيئة ودعم اقتصاد الشركة، تبدأ صناعة النسيج من الزراعة وحتى البيع بالتجزئة تؤثر الصناعات التحويلية للمنسوجات بطريقة مختلفة على البيئة، مثل استخدام المياه في زراعة القطن، واستهلاك الطاقة في جميع العمليات، واستخدام المواد المعالجة والكيميائية.
            </p>
            <p>
                وذكرت (هند العاني، وعلى تويج ، 2018، ص 334) ان الاستدامة لن تشكل عبئا في النسيج على الميزانية كما يعتقد البعض فأن تصبح صديق للبيئة يمكن أن يكون سهلا، حيث تعددت طرق إنتاج النسيج وتنوعت معها وسائل تعديل الإنتاج لجعله أقل ضرر على البيئة، وهناك العديد من المناقشات بدءً من سلامة العاملين في هذا القطاع، والتأثيرات البيئية للمواد الكيميائية المستخدمة في النسيج، ان الشركات التي تجعل الاستدامة هدفا رئيسيا لها مستقبلا فقط هي التي ستتميز بالتنافسية.
            </p>

            <h3 class="text-xl font-bold text-gray-700 mt-8 mb-2">مفهوم الاستدامة:</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">The Concept of Sustainability</h4>
            <p>
                ينطلق مصطلح الاستدامة من النظرة الإنسانية التي تدعو الى الاهتمام بمستقبل الانسان والمحافظة على البيئة التي تعطي للإنسان الاستمرارية، اذ اعتمدت على كيفية استخدام الموارد الطبيعية بأفضل صورة ممكنة مع الحفاظ على ابقائها.
            </p>
            <span class="citation-ar">(علي شمس، واخرون ، 2023، ص 137)</span>

            <h3 class="text-xl font-bold text-gray-700 mt-8 mb-2">المبادئ الأساسية للاستدامة :</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">The Core Principles of Sustainability</h4>
            <ul class="list-disc text-gray-800">
                <li>الدمج وتحقيق التكامل بين كل القطاعات الاجتماعية والاقتصادية والبيئية عن وضع سياسات الاستدامة.</li>
                <li>فصل التدهور البيئي عن النمو الاقتصادي، حيث تكون إدارة النمو الاقتصادي قائمه على التقليل من التلوث وترشيد استهلاك الموارد.</li>
                <li>المساواة والعدالة بين الأجيال تزويد الأجيال القادمة بنفس الاحتياجات البيئية على النحو القائم حاليا. <span class="citation-ar inline mr-2">(عفراء الحسون، 2023، ص 109)</span></li>
                <li>منع الضرر الذي يصعب الغاؤه بالمدى الطويل على النظم البيئية وصحة الانسان.</li>
                <li>المحافظة على البيئة والمرونة معها، تعزيز القدرة على التكيف مع النظام البيئي.</li>
                <li>نشر الوعي التعليمي والمشاركة الشعبية بين المجتمعات المحلية والناس لبحث المشاكل ووضع حلول جديدة لها. <span class="citation-ar inline mr-2">(علاء إسماعيل، وسلوى البازي ، 2009، ص2)</span></li>
            </ul>

            <h3 class="text-xl font-bold text-gray-700 mt-8 mb-2">الابعاد الرئيسية للتنمية المستدامة:</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">The Main Dimensions of Sustainability:</h4>
            <p>للتنمية المستدامة ثلاث ابعاد رئيسية تعتبر الوحدة الأساسية لها وهي:</p>
            
            <figure class="my-8">
                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة شكل (2): الابعاد الرئيسية للتنمية المستدامة (مخطط دائري يوضح البعد الاقتصادي، البعد البيئي، البعد الاجتماعي)" class="w-full h-auto rounded object-cover" data-desc="صورة شكل (2): الابعاد الرئيسية للتنمية المستدامة (مخطط دائري يوضح البعد الاقتصادي، البعد البيئي، البعد الاجتماعي)" />
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (2) الابعاد الرئيسية للتنمية المستدامة
                </figcaption>
            </figure>

            <h3 class="text-xl font-bold text-gray-700 mt-8 mb-2">أهداف التنمية المستدامة الـ(SDG)</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">The Goals of Sustainability</h4>
            <p>
                مجموعة الأهداف السبعة عشر التي اعتمدتها الأمم المتحدة عام 2015، وتعرف أيضاً باسم (أجندة العالم 2030)، وهي عبارة عن رؤية ونداء عالمي من أجل القضاء على الفقر وحماية الكوكب وضمان تمتع جميع الناس بالسلام والازدهار بحلول عام 2030.
            </p>
            <span class="citation" dir="ltr">(https://sahl.io/sa)</span>

            <figure class="my-8">
                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (37): شبكة أهداف التنمية المستدامة الـ 17 للأمم المتحدة" class="w-full h-auto rounded object-cover" data-desc="صورة (37): شبكة أهداف التنمية المستدامة الـ 17 للأمم المتحدة" />
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (37) توضح الأهداف السبعة عشر للإستدامة<br>
                    <span dir="ltr">(https://www.hrdf.org.sa)</span>
                </figcaption>
            </figure>

            <p>
                كما تسعى إلى تحقيق أهداف التنمية الاجتماعية بموافقة جميع الدول أعضاء الأمم المتحدة ودعمها على نطاق واسع من المجتمع المدني، وتركز على خمسة عناصر مترابطة (الناس، الكوكب، الازدهار السلام الشراكات كإطار شامل متشابكا فهي ليست اهداف منعزلة، تقتضي العمل التعاوني مع ابتكار خيارات جديدة لتحسين الحياة بطريقة مستدامة للأجيال القادمة، بالإضافة الى مبادئ توجيهية واضحة لتطبيقها على الأولويات والخطط الوطنية، مع التركيز على التحديات، وتمثل خارطة طريق لمعالجة الأسباب الجذرية للفقر وتوحد الشعوب لإحداث تغيير إيجابي للعالم، وتركز على شمولية الجميع اذ لا يمكن للدولة أن تعمل لوحدها في تحقق النمو الاجتماعي والاقتصادي، بل يجب عليها التكاتف والتعاون لضمان تحقيق الأهداف للعالم.
            </p>
            <span class="citation" dir="ltr">(https://www.stats.gov.sa)</span>
        </section>

        <!-- PAGE 3 & 4 -->
        <section class="mb-14">
            <h3 class="text-xl font-bold text-gray-700 mt-8 mb-4">الاعتبارات البيئية التي تجعل الياف النسيج مستدامة" صديقة للبيئة:</h3>
            <ul class="list-decimal text-gray-800">
                <li>استخدام الياف عضوية وموارد طبيعية مستدامة.</li>
                <li>المراعاة البيئية في مراحل الإنتاج سواء في الصرف الصحي للمياه والطاقة واستهلاك المياه.</li>
                <li>تأثير المدخلات الكيميائية سواء في الاصباغ أو المواد الكيميائية المعالجة، لمراعاة الآثار الصحية على العاملين في مصانع النسيج والمستهلكين للمنتج النهائي.</li>
                <li>إمكانية إعادة التدوير للنسيج وقابليته للتحلل البيولوجي.</li>
            </ul>

            <h3 class="text-xl font-bold text-gray-700 mt-10 mb-2">دور الاستدامة في النسيج</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">The Role of Sustainability in Textiles</h4>
            <span class="citation">(Antony, R. & Suparna, m., 2016, p.70)</span>
            <p>
                تلعب الاستدامة دورا حيويًا في معالجة المنسوجات حيث أن متطلبات اليوم هي انتاج سلع صديقة للبيئة، لديها القدرة على خدمة العميل والبيئة ودعم اقتصاد الشركة، تبدأ صناعة النسيج من الزراعة وحتى البيع بالتجزئة تؤثر الصناعات التحويلية للمنسوجات بطريقة مختلفة على البيئة، مثل استخدام المياه في زراعة القطن، واستهلاك الطاقة في جميع العمليات واستخدام المواد المعالجة والكيميائية.
            </p>

            <h3 class="text-xl font-bold text-gray-700 mt-10 mb-2">دور الاستدامة في الفن والتصميم</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">The Role of Sustainability in Art and Design:</h4>
            <span class="citation">(Minh, N., & Ngan, H., 2021, P.27)</span>
            <p>
                تسعى الاستدامة في الفن والتصميم إلى دمج الممارسات البيئية والاجتماعية في العملية الإبداعية لضمان استمرارية الموارد وتقليل التأثيرات البيئية، يركز الفنانين والمصممين على استخدام مواد مستدامة، وإعادة التدوير، وتبني أساليب إنتاج تقلل من الهدر وتحد من التلوث، تتجلى هذه المبادئ في تصميم المنتجات والهندسة المعمارية، والفنون البصرية.
            </p>

            <h3 class="text-xl font-bold text-gray-700 mt-8 mb-2">أهم جوانب الاستدامة في التصميم والفن:</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">The Most Important Aspects of Sustainability in Art and Design:</h4>
            <ul class="list-disc text-gray-800">
                <li><strong>اختيار المواد:</strong> استخدام مواد صديقة للبيئة مثل: الأصباغ الطبيعية.</li>
                <li><strong>التصميم المبتكر:</strong> إيجاد حلول تصميمية تخدم الاحتياجات الحالية مثل: التصميم القابل للتفكيك وإعادة الاستخدام.</li>
                <li><strong>التوعية البيئية:</strong> استخدام الفن كأداة لرفع الوعي بأهمية حماية البيئة.</li>
                <li><strong>التقنيات الحديثة:</strong> الاعتماد على التكنولوجيا لتحسين كفاءة العمليات مثل: الطباعة ثلاثية الأبعاد.</li>
            </ul>
            <span class="citation">(McDonough, W., & Braungart, M., 2010, p.45)</span>
        </section>

        <!-- PAGE 5 & 6 & 7 -->
        <section class="mb-14">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-r-4 border-green-500 pr-3">ثانيا / الاقمشة المستدامة "الصديقة للبيئة" :</h2>
            <h3 class="text-xl font-bold text-gray-700 mb-3">مقدمة :</h3>
            <p>
                ان الالياف النسيجية الصديقة للبيئة ليس لها أي ضرر على الحياة ولا تسبب أي مخاطر أو مواد سامه في مراحل انتاجها المختلفة، حيث ان تصميم وإنتاج المنسوجات يعتبر امرا صعبًا جدا وبالتالي فإن الاهتمام الحالي يركز على انتاج المنسوجات الصديقة للبيئة، والتي تحافظ على الحياة ولا تضر بها، لذلك يجب اتباع قوانين المحافظة على البيئة بشدة، بداية من انتقاء المواد الخام ثم التجهيز ومرورًا باستخدام المياه الى ان تصل الى المنتج النهائي بشكل آمن.
            </p>
            <span class="citation-ar">(أحمد مصطفى، 2010، ص 110)</span>
            <p>
                كما تصنف الأقمشة الصديقة للبيئة من المواد التي يتم إنتاجها وتصنيعها بطرق تهدف إلى تقليل التأثير السلبي على البيئة مقارنةً بالأقمشة التقليدية، كما يتم إنتاج هذه الأقمشة مع تقليل استهلاك المياه والطاقة والتقليل من استخدام المواد الكيميائية الضارة مثل المبيدات والأسمدة الصناعية، حيث تزايد الطلب على الأقمشة الصديقة للبيئة مع زيادة الوعي البيئي لدى المستهلكين والشركات على حد سواء، اذ انها جزءًا أساسيًا من حركة الموضة المستدامة، التي تسعى إلى تقليل التلوث البيئي المرتبط بصناعة الأزياء والنسيج، على الرغم من أن التحديات تظل قائمة في مجال إنتاج هذه الأقمشة بكفاءة عالية وتكلفة مناسبة، إلا أن الاستثمارات في التكنولوجيا الخضراء وإعادة تدوير المواد تشهد تقدمًا كبيرا، مما يعزز دور الأقمشة الصديقة للبيئة في المستقبل.
            </p>
            <span class="citation">(Smith, J., 2020, p: 127)</span>

            <div class="flex flex-col md:flex-row gap-8 items-start my-10">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-700 mb-2">عوامل البيئة وعلاقتها في تصميم الاقمشة</h3>
                    <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">Environmental Factors and Their Relation to Fabric Design:</h4>
                    <p>
                        يرتبط تصميم الاقمشة ارتباطا وثيقاً بالبيئة لكونها تتمثل بعوامل داخلية وخارجية متنوعة ومتداخلة مع بعضها ومتوافقة لتحقيق الهدف التصميمي، تتعلق العوامل الداخلية بقدرات مصمم الاقمشة وسماته الشخصية وقوة دوافعه وخبراته، أما العوامل الخارجية فتتمثل بالبيئة المحيطة به كالبيئة الاجتماعية والثقافية والسياحية والاقتصادية والدينية والفيزيائية، كما تلعب خبرة المصمم دور مباشراً في مقدار تذوقه للبيئة المحيطة به؛ وأساسها الوصول والتوليف للعناصر والاختلاف في صفاتها ضمن العمل التصميمي حيث تساهم في تفرد القماش دون تأثره في وحدة التصميم.
                    </p>
                    <span class="citation-ar">(علي الشمري ، 2019، ص 445)</span>
                </div>
                <div class="w-full md:w-1/3">
                    <figure>
                        <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة شعار: Environmentally Friendly (شجرة خضراء)" class="w-full h-auto rounded object-cover" data-desc="صورة شعار: Environmentally Friendly (شجرة خضراء)" />
                        <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                            شكل (3) شعار صديق للبيئة<br>
                            <span dir="ltr">(https://www.pngegg.com)</span>
                        </figcaption>
                    </figure>
                </div>
            </div>

            <h3 class="text-xl font-bold text-gray-700 mt-10 mb-4">الالياف النسجية المستخدمة في تصنيع وإنتاج الاقمشة المستدامة:</h3>
            <p>
                يسعى الباحثون في مجال الأزياء والنسيج إلى إيجاد حلول للمشاكل البيئية الصادرة من الألياف التقليدية، إذ وجدت ألياف طبيعية عضوية غير الألياف التقليدية، وكذلك ألياف حيوية، وألياف معاد تدويرها، والشكل (4) يبين مجموعة الألياف المستخدمة في تصنيع وإنتاج الأقمشة الصديقة للبيئة:
            </p>

            <figure class="my-10">
                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة شكل (4): شجرة تصنيف الألياف الصديقة للبيئة (طبيعية، معاد تدويرها، صناعية، عضوية)" class="w-full h-auto rounded object-cover" data-desc="صورة شكل (4): شجرة تصنيف الألياف الصديقة للبيئة (طبيعية، معاد تدويرها، صناعية، عضوية)" />
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (4) تصنيف الألياف الصديقة للبيئة
                </figcaption>
            </figure>
        </section>

        <!-- PAGE 7 & 8 -->
        <section class="mb-14">
            <h3 class="text-xl font-bold text-gray-700 mt-8 mb-2">مفهوم الاقمشة المستدامة" الصديقة للبيئة" :</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">The Concept of Eco-Friendly Fabrics:</h4>
            <p>
                أقمشة وخامات تم تصنيعها وتصميمها من ألياف طبيعية عضوية لا تتطلب استخدام مبيدات حشرية أو مواد كيميائية في زراعتها، فهي مقاومة للعفن وخالية من الأمراض، كما أن هدفها الحد من الآثار البيئية للحفاظ على البيئة من التلوث الصادر من عمليات الإنتاج والتصنيع، فبالتالي تحسين المنتج، وتعد المواد الخام المستخدمة في صناعة الملابس من أكبر الملوثات في العالم، حيث يتم استخدام ما لا يقل عن 8000 مادة كيميائية لتصنيع المواد وهذا احد مسببات الأمراض الخطيرة، لذلك تم العمل على الزراعة العضوية لتجنب الأضرار الناتجة عنها.
            </p>
            <span class="citation-ar">(شيماء أحمد، 2020 ، ص 163)</span>

            <h3 class="text-xl font-bold text-gray-700 mt-10 mb-2">أنواع الأقمشة المستدامة "الصديقة للبيئة":</h3>
            <h4 class="text-lg text-gray-500 mb-4 font-sans" dir="ltr">Types of sustainable "environmentally friendly" fabrics:</h4>
            <p>تتوفر أنواع عديدة من الأقمشة الصديقة للبيئة، ولكل منها خصائص وفوائد، من أشهر هذه الأقمشة:</p>

            <!-- Organic Cotton -->
            <div class="mt-8 border-t border-gray-200 pt-8">
                <h4 class="text-lg font-bold text-green-700 mb-2">1. قماش القطن العضوي.</h4>
                <p class="text-gray-500 font-sans mb-4" dir="ltr">Organic cotton fabric</p>
                
                <div class="flex flex-col md:flex-row gap-8 items-start mb-6">
                    <div class="flex-1">
                        <p>
                            <strong>مفهوم القطن العضوي:</strong> هو القطن الذي يتم انتاجه، وفق المعايير الزراعية العضوية، حيث يزرع دون استخدام أي مبيدات حشرية او اسمدة صناعية، ويزرع القطن العضوي كجزء من نظام الإنتاج الذي يحافظ على خصوبة التربة والنظم البيولوجية والانسان، وهي تعتمد على العمليات الحيوية والتنوع البيولوجي والمدخلات الطبيعية محليًا بدلا من المدخلات الكيمائية التي يمكن أن يكون لها آثار سلبية على البيئة، شكل (5) يبين رمز القطن العضوي.
                        </p>
                        <span class="citation">(Bahlool, S., & et al, 2024, p.4032)</span>
                    </div>
                    <div class="w-full md:w-1/3">
                        <figure>
                            <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="شكل (5): مجموعة أيقونات 100% Organic Cotton" class="w-full h-auto rounded object-cover" data-desc="شكل (5): مجموعة أيقونات 100% Organic Cotton" />
                            <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                                شكل (5) يوضح رمز القطن العضوي<br>
                                <span dir="ltr">(https://ar.pngtree.com)</span>
                            </figcaption>
                        </figure>
                    </div>
                </div>

                <p>
                    <strong>استخراج الألياف:</strong> تبدأ الرحلة بزراعة القطن العضوي بدون استخدام الأسمدة الكيميائية أو المبيدات الحشرية، بعد عملية النمو يتم حصاد القطن الناضج يدويًا أو ميكانيكيا بألة حصاد القطن كما في صورة (38) ، في المرحلة الثانية عملية الحلج اذ بها يتم إزالة البذور، وتنظيف الشوائب للحصول على ألياف نظيفة، بعد ذلك يتم نفش ألياف القطن ثم غزلها إلى خيوط بعد ذلك تأتي عملية الصباغة والتشطيب يتم فيها صبغ الالياف باستخدام الأصباغ النباتية الصديقة للبيئة، في نهاية الرحلة تأتي عملية نسج الالياف في القماش للحصول على منتجات، رمز الاستجابة (1) يبين عملية استخراج الياف القطن العضوي.
                </p>
                <span class="citation" dir="ltr">(https://recovo.co)</span>

                <div class="flex flex-col md:flex-row gap-6 my-6 justify-center">
                    <figure class="flex-1 max-w-xs mx-auto">
                        <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (38): آلة حصاد القطن الحمراء" class="w-full h-auto rounded object-cover" data-desc="صورة (38): آلة حصاد القطن الحمراء" />
                        <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                            صورة (38) آلة حصاد القطن<br>
                            <span dir="ltr">(https://sa.fmworldagri.com)</span>
                        </figcaption>
                    </figure>
                    <figure class="flex-1 max-w-xs mx-auto">
                        <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="رمز QR (1)" class="w-full h-auto rounded object-cover" data-desc="رمز QR (1)" />
                        <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                            رمز الاستجابة (1) عملية استخراج الياف القطن
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <!-- PAGE 8 & 9 -->
        <section class="mb-14">
            <p>
                <strong>تركيب الألياف:</strong> تحتوي ألياف القطن على 90-95% من السليلوز، وهو مركب عضوي صيغته العامة $(C_6H_{10}O_5)_n$ تحتوي أيضًا على شمع وبكتين وأحماض عضوية ومواد غير عضوية تنتج رمادًا عند احتراقها، ويظهر القطاع العرضي لشعيرة القطن بشكل كلوي، يتميز بجدار أولي رقيق من السليلوز تحمية قشرة خارجية، ثم طبقات متتالية وهي ما يسمى بالجدار الثانوي، وتتكون الترسبات السليلوزية على شكل مجموعات من الجزئيات في ترتيب حلزوني، وفي الوسط تجويف عصاري يحتوي على الغذاء يمتد بطول الشعيرة، ويظهر القطاع الطولي للشعيرة بشكل شريطي ذو التواءات منتظمة، ويقل السمك عن الطرف، وتظهر الفجوة الداخلية كخط بطول الشعيرة خاصة في حالة الشعيرات الغير ناضجة، شكل (6) القطاع الطولي والعرضي لالياف القطن.
            </p>
            <span class="citation">(Awais, H. & et al, 2021, p.2-5)</span>

            <div class="flex flex-col md:flex-row gap-6 items-center my-8">
                <figure class="flex-1">
                    <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="شكل (6): القطاع الطولي والعرضي تحت المجهر" class="w-full h-auto rounded object-cover" data-desc="شكل (6): القطاع الطولي والعرضي تحت المجهر" />
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        شكل (6) توضح القطاع العرضي والطولي لألياف القطن العضوي<br>
                        <span dir="ltr">(Kumari, A., & Khurana, K. 2016, P.6)</span>
                    </figcaption>
                </figure>
                <figure class="w-full md:w-1/3">
                    <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (39): قماش قطن عضوي مطوي" class="w-full h-auto rounded object-cover" data-desc="صورة (39): قماش قطن عضوي مطوي" />
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        صورة (39) قماش القطن العضوي<br>
                        <span dir="ltr">(https://arabic.alibaba.com)</span>
                    </figcaption>
                </figure>
            </div>

            <h4 class="font-bold text-gray-700 mt-6 mb-3">مميزات قماش القطن العضوي:</h4>
            <p>للقطن العضوي مجموعة من الفوائد منها ما يلي:</p>
            <ul class="list-disc text-gray-800">
                <li>خيار مثاليا للبشرة الحساسة، اذ انه يتميز بألياف مضادة للحساسية وناعمة الملمس.</li>
                <li>قدرته على امتصاص الرطوبة، لهذا السبب يستخدم في صناعة الملابس والأحذية.</li>
                <li>لا يولد كهرباء ساكنة على عكس الألياف الاصطناعية.</li>
                <li>أقمشة القطن العضوي سهلة الغسل ولا تحتاج عادةً إلى كتي.</li>
                <li>من فوائد القطن العضوي التقليل من استهلاك المياه والطاقة في الزراعة.</li>
                <li>خال من السموم، حيث يتم استخدام الألياف العضوية والأصباغ الطبيعية فقط في تصنيعه. <span class="citation inline ml-2" dir="ltr">(https://povedatextil.com)</span></li>
            </ul>

            <!-- Bamboo -->
            <div class="mt-12 border-t border-gray-200 pt-8">
                <h4 class="text-lg font-bold text-green-700 mb-2">2. قماش الخيزران "البامبو".</h4>
                <p class="text-gray-500 font-sans mb-4" dir="ltr">Bamboo fabric</p>
                
                <p>
                    <strong>مفهوم البامبو:</strong> هو أحد النباتات العملاقة المجوفة في الغابات الاستوائية الحارة، ويصنف من الخامات الصديقة للبيئة فهو مورد متجدد، قليل التأثير بالعوامل الجوية كالحرارة والرطوبة، يتطلب بزراعته الحد الأدنى من الماء والمبيدات والاسمدة مقارنةً بالألياف الأخرى، لأن قدرته عالية على التكيف مع مختلف المناخ والتربة فبذلك لا يحتاج الى المدخلات الاصطناعية، كما يقاوم تأكل التربة وتعزيز المادة العضوية فيها واحتباس الماء ان من المهم حصاد الخيزران في الوقت المناسب لضمان الالياف المثالية، ومن الممكن ان يكون نسيج الخيزران عالي الجودة متينا ويدوم طويلا، الا أن اختلاف جودة ومتانة الخيزران تعتمد اعتماد كلي على عملية التصنيع والعلامة التجارية المحددة، صورة (40) توضح نبات الخيزران والقماش المنتج من الخيزران، شكل (7) يبين شعار الخيزران العضوي.
                </p>
                <span class="citation">(Aishwariya, S., & Adhiya, R., 2023, P.134)</span>

                <div class="flex flex-col md:flex-row gap-6 justify-center items-center my-8">
                    <figure class="w-full md:w-1/4">
                        <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="شكل (7): شعار Organic Bamboo" class="w-full h-auto rounded object-cover" data-desc="شكل (7): شعار Organic Bamboo" />
                        <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                            شكل (7) شعار البامبو العضوي<br>
                            <span dir="ltr">(https://www.shutterstock.com)</span>
                        </figcaption>
                    </figure>
                    <figure class="flex-1">
                        <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (40): نبات الخيزران وقماش البامبو بجانبه" class="w-full h-auto rounded object-cover" data-desc="صورة (40): نبات الخيزران وقماش البامبو بجانبه" />
                        <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                            صورة (40) توضح نبات الخيزران، والقماش المصنوع من الخيزران<br>
                            <span dir="ltr">(https://ar.yushengmax.com)</span>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <!-- PAGE 10 & 11 -->
        <section class="mb-14">
            <p><strong>استخراج الالياف :</strong> تُستخرج ألياف البامبو بطريقتين رئيسيتين:</p>
            <ul class="list-disc text-gray-800">
                <li><strong>الطريقة الميكانيكية:</strong> يُفصل ساق البامبو ويُقطع إلى شرائح تسحق وتُعالج بإنزيمات طبيعية، لتحولها إلى كتل إسفنجية، ثم تفصل الألياف بالتمشيط الميكانيكي لفصل الالياف ثم تغزل إلى خيوط. <span class="citation-ar inline mr-2">(عادل عبد المنعم، وآخرون، 2023، ص 49)</span></li>
                <li><strong>الطريقة الكيميائية:</strong> تسحق السيقان والأوراق الداخلية معًا وتنقع في محلول هيدروكسيد الصوديوم (NaOH) فيما يُعرف بالتحلل القلوي، ثم تضغط للتخلص من المحلول الزائد وتجفف، بعد ذلك يُضاف كبريتيد الكربون لتكوين مادة إسفنجية، ثم يُعاد خلطها بـ NaOH لتكوين الفسكوز، يمرر الفسكوز عبر ثقوب دقيقة في حوض يحتوي على حمض الكبريتيك المخفف لتقوية الألياف الناتجة، والتي تُغزل لاحقا إلى خيوط خيزران تحويلية، يوضح رمز الاستجابة (2) عملية استخراج الياف البامبو. <span class="citation inline ml-2">(Yao, W., & Zhang, W., 2011, p.29)</span></li>
            </ul>

            <figure class="my-6 max-w-xs mx-auto">
                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="رمز QR (2)" class="w-full h-auto rounded object-cover" data-desc="رمز QR (2)" />
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    رمز الاستجابة (2) عملية استخراج الياف البامبو
                </figcaption>
            </figure>

            <p>
                <strong>تركيب الالياف:</strong> تتكون الياف البامبو من طبقات ليفية عريضة وضيقة بالتبادل فيما بينها، تحتوي طبقاتها على الياف السليلوز والهيميسليلوز المرتبة في اتجاهات وزايا مختلفة داخل مصفوفة اللجنين على امتداد القطاع الطولي لألياف البامبو مما يعمل على زيادة شد الالياف، لذلك أطلق عليها مسمى "الألياف الطبيعية الزجاجية"، كما يظهر وجود فواصل بين الالياف، اذ يظهر سطحها خشنا نتيجة تجويفها، والقطاع العرضي يظهر بشكل سداسي غير منتظم، والشكل (8) يبين القطاع الطولي والعرضي لألياف البامبو تحت المجهر.
            </p>
            <span class="citation">(Roslan, S., & et al, 2015, p.6279)</span>

            <figure class="my-6 max-w-md mx-auto">
                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="شكل (8): المجهر لالياف Regenerated bamboo" class="w-full h-auto rounded object-cover" data-desc="شكل (8): المجهر لالياف Regenerated bamboo" />
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (8) توضح القطاع الطولي والعرضي لألياف البامبو<br>
                    <span dir="ltr">(Kumari, A., & Khurana, K., 2016.,P 6)</span>
                </figcaption>
            </figure>

            <h4 class="font-bold text-gray-700 mt-6 mb-3">مميزات قماش البامبو :</h4>
            <p>يتمتع نسيج الخيزران بالعديد من المزايا منها ما يلي:</p>
            <ul class="list-disc text-gray-800">
                <li>يتميز نسيج الخيزران بالنعومة الفائقة، وغالبًا ما يتم مقارنته بالكشمير، مما يجعله مريحًا للارتداء اليومي ومناسب للبشرة الحساسة.</li>
                <li>توفر أليافها عزلاً حراريا ممتازا.</li>
                <li>يتمتع الخيزران بقدرة عالية على امتصاص الرطوبة، وهذا ما يجعل اختياره مثاليا لإنتاج الملابس الرياضية وملابس الصيف.</li>
                <li>مضاد للبكتيريا ويقاوم الروائح لفترة طويلة.</li>
                <li>يتميز نسيج الخيزران بالحماية طبيعية من الأشعة فوق البنفسجية.</li>
            </ul>
            <span class="citation" dir="ltr">(https://www.croftmill.co.uk)</span>

            <!-- Recycled Polyester -->
            <div class="mt-12 border-t border-gray-200 pt-8">
                <h4 class="text-lg font-bold text-green-700 mb-2">3. قماش البولستر المعاد تدويره.</h4>
                <p class="text-gray-500 font-sans mb-4" dir="ltr">recycled polyester fabric</p>
                
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    <div class="flex-1">
                        <p>
                            <strong>مفهوم البوليستر المعاد تدويره:</strong> يُعرف تحويل النفايات البلاستيكية إلى منتجات جديدة قابلة للاستهلاك صورة (41)، إذ يعزز من تقليل استخدام المواد الخام في التصنيع، مما يوفر الطاقة وتجنب التلوث في الولايات المتحدة يتم التخلص من 4 ملايين علبة بلاستيكية كل ساعة كما يؤدي ذلك إلى مشاكل بيئية، يتم معالجة هذه المشكلة بإعادة تدوير العلب البلاستيكية المستهلكة وتحويلها إلى ألياف بوليستر معاد تدوير، وشكل (9) يوضح شعار البوليستر المعاد تدويره.
                        </p>
                        <span class="citation-ar">(دعاء أحمد، 2024 ، ص 156)</span>
                    </div>
                    <div class="w-full md:w-1/3 space-y-6">
                        <figure>
                            <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="شكل (9): شعار 100% Recycled Polyester" class="w-full h-auto rounded object-cover" data-desc="شكل (9): شعار 100% Recycled Polyester" />
                            <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                                شكل (9) شعار البوليستر المعاد تدويره<br>
                                <span dir="ltr">(https://www.loopworkwear.co.nz)</span>
                            </figcaption>
                        </figure>
                        <figure>
                            <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (41): كومة من النفايات البلاستيكية" class="w-full h-auto rounded object-cover" data-desc="صورة (41): كومة من النفايات البلاستيكية" />
                            <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                                صورة (41) النفايات البلاستيكية<br>
                                <span dir="ltr">(https://www.bbc.com)</span>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </section>

        <!-- PAGE 12 & 13 -->
        <section class="mb-14">
            <p>
                <strong>استخراج الألياف:</strong> يُنتج معظم نسيج البوليستر المعاد تدويره عبر عملية إعادة التدوير الميكانيكية، والتي تتضمن تقطيع البلاستيك إلى رقائق ثم إذابته وبثقه لإنتاج ألياف بوليستر جديدة، وعملية إعادة التدوير الكيميائية التي تقوم بتفكيك النفايات البلاستيكية إلى وحدات المونومر من خلال إزالة البلمرة، بعد ذلك تنقى هذه المونومرات وتعاد بلمرتها لإنتاج ألياف جديدة، وتعد إعادة التدوير الكيميائية للبوليستر أقل شيوعًا مقارنةً بالإعادة الميكانيكية نظرًا لارتفاع تكاليف الإنتاج، يُظهر رمز الاستجابة (3) عملية تحويل النفايات البلاستيكية الى بوليستر معاد تدويره.
            </p>
            <span class="citation" dir="ltr">(https://www.ecolife.com)</span>

            <figure class="my-6 max-w-xs mx-auto">
                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="رمز QR (3)" class="w-full h-auto rounded object-cover" data-desc="رمز QR (3)" />
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    رمز الاستجابة (3) عملية انتاج البوليستر المعاد تدويره
                </figcaption>
            </figure>

            <p>
                <strong>تركيب الألياف:</strong> تظهر الألياف البوليسترية (PET) المعاد تدويره عادةً ما تكون دائرية في المقطع العرضي، مما يوفر سطح ناعم منتظم يعزز لمعان النسيج، وتوجد أنواع ذات مقطعات خاصة مثل ثلاثية الجوانب (trilobal)، تُصنع لتعزيز الانعكاس واللمعان، ومحاكاة الحرير الصناعي، كما تظهر حفرة واضحة في المقطع العرضي، إذ بسببها يقل الوزن والكثافة الحرارية، ويزيد الأداء العازل، ويظهر المقطع الطولي كأسطوانة منتظمة وخالية من الشرائط؛ بسطح أملس متجانس، عند فحص ألياف البوليستر المعاد تدويرها تحت المجهر، قد يُظهر بعض الاختلافات الطفيفة بسبب عملية إعادة التدوير مثل وجود بعض الشوائب أو الاختلافات الدقيقة في الشكل أو الحجم بسبب التكسير والانصهار أثناء إعادة التدوير، الشكل (10) تبين المقطع الطولي والعرضي للألياف تحت المجهر .
            </p>
            <span class="citation">(Yang, T., & et al 2019, p.3342-3361)</span>

            <figure class="my-6 max-w-md mx-auto">
                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="شكل (10): القطاع الطولي والعرضي للبوليستر المعاد تدويره" class="w-full h-auto rounded object-cover" data-desc="شكل (10): القطاع الطولي والعرضي للبوليستر المعاد تدويره" />
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    الشكل (10) تبين القطاع الطولي والعرضي لألياف البوليستر المعاد تدويره<br>
                    <span dir="ltr">(https://www.modip.ac.uk)</span>
                </figcaption>
            </figure>

            <h4 class="font-bold text-gray-700 mt-6 mb-3">مميزات قماش البوليستر المعاد تدويره</h4>
            <p>هناك مميزات عديدة القماش البوليستر المعاد تدويره منها ما يلي :</p>
            <ul class="list-disc text-gray-800">
                <li>مقاومة التجاعيد والانكماش حيث انه لا يتجعد بسهولة، مما يجعله خيارًا مثاليا للملابس الرسمية والمفروشات.</li>
                <li>سرعة الجفاف وسهولة الغسل اذ انه يجف بسرعة مقارنة بالأقمشة الطبيعية، مما يجعله مثاليا للسفر والاستخدام اليومي.</li>
                <li>قابلية الصباغة الممتازة، مما يجعله يمتص الألوان بشكل جيد ويحافظ عليها لفترة طويلة دون أن يتلاشى.</li>
                <li>بالإضافة الى ان قوة متانته عالية ومقاوم للتمزق.</li>
                <li>مقاوم للبقع والزيوت وخفيف الوزن، وصورة (42) توضح قماش منتج من البوليستر المعاد تدويره وصورة (43) خيط مصنوع البوليستر المعاد تدويره.</li>
            </ul>
            <span class="citation" dir="ltr">(https://aqmicha.com)</span>

            <div class="flex flex-col md:flex-row gap-6 justify-center items-center my-8">
                <figure class="flex-1 max-w-sm">
                    <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (42): قماش ازرق مجعد (بوليستر)" class="w-full h-auto rounded object-cover" data-desc="صورة (42): قماش ازرق مجعد (بوليستر)" />
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        صورة (42) قماش منتج البوليستر المعاد تدويره<br>
                        <span dir="ltr">(https://sa.bangtaitex.com)</span>
                    </figcaption>
                </figure>
                <figure class="flex-1 max-w-sm">
                    <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (43): تطبيقات خيوط البوليستر" class="w-full h-auto rounded object-cover" data-desc="صورة (43): تطبيقات خيوط البوليستر" />
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        صورة (43) خيط مصنوع من البوليستر المعاد تدويره<br>
                        <span dir="ltr">(http://functional-yarns.asia)</span>
                    </figcaption>
                </figure>
            </div>

            <!-- Organic Linen -->
            <div class="mt-12 border-t border-gray-200 pt-8">
                <h4 class="text-lg font-bold text-green-700 mb-2">4. قماش الكتان العضوي.</h4>
                <p class="text-gray-500 font-sans mb-4" dir="ltr">Organic linen fabric</p>
                
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    <div class="flex-1">
                        <p>
                            <strong>مفهوم الكتان العضوي:</strong> نبات من أصل سليلوزي، يعتبر من النباتات العشبية ذات التركيب البسيط وهو من أقدم النباتات التي استخدمت أليافه لصناعة المنسوجات، يختلف عن الكتان التقليدي بأنه لا يستخدم في زراعته مبيدات حشرية ومواد كيميائية، يزرع في شمال إيطاليا ويطلق عليه " الكتان الحيوي"، يصنف من النباتات الصديقة للبيئة لكونه يقلل من التأثيرات السلبية للبيئة، ويستهلك كمية قليلة من الطاقة المتجددة والماء، شكل (11) يوضح رمز الكتان العضوي المستخدم في الاقمشة الصديقة للبيئة.
                        </p>
                        <span class="citation">(Hammash, A., 2023, p. 36)</span>
                    </div>
                    <div class="w-full md:w-1/4">
                        <figure>
                            <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="شكل (11): شعار Organic Linen" class="w-full h-auto rounded object-cover" data-desc="شكل (11): شعار Organic Linen" />
                            <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                                شكل (11) يوضح رمز الكتان العضوي<br>
                                <span dir="ltr">(https://www.shutterstock.com)</span>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </section>

        <!-- PAGE 14 & 15 -->
        <section class="mb-14">
            <p>
                <strong>استخراج الألياف:</strong> توجد الألياف بساق النبات على شكل حزم كاملة بطول النبات بين القلب الخشبي والقشرة، تتكون كل حزمة بعدد كبير من الخلايا الليفية مرتبة وملتصقه بالبكتين بجانب بعضها، كما تلتصق ايضًا بجذع النبات وخلايا الساق عند استخراج الألياف يجب إزالة المادة الصمغية اولا عن طريق التعطين والتي تتم بفعل البكتريا مع الماء، ثم تمر بالتجفيف، بعد ذلك التكسير والتي يتم فيها تكسير القلب الخشبي إلى قطع صغيرة يمكن فصلها عن الألياف، بعد ذلك عملية التنفيض وهي إزالة القطع الخشبية من حزم الألياف، تأتي بعدها عملية التمشيط لإتمام فصل وفك تلاصق الشعيرات اخيرا تأتي عملية الغزل والتي تتم اماً بالغزل الجاف أو الرطب، في هذه العمليه يسحب الناتج إلى خيوط مع إعطاء البرم المناسب، رمز الاستجابة (4) يوضح عملية استخراج الكتان وتحويله الى الياف.
            </p>
            <span class="citation">(Namrata Dhirhi, N.& et al, 2015, p.712-716)</span>

            <figure class="my-6 max-w-xs mx-auto">
                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="رمز QR (4)" class="w-full h-auto rounded object-cover" data-desc="رمز QR (4)" />
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    رمز الاستجابة (4) عملية استخراج الكتان وتحويلة الى الياف
                </figcaption>
            </figure>

            <p>
                <strong>تركيب الألياف :</strong> يمثل السليلوز المكون الرئيسي للالياف، حيث يشكل حوالي 71% من تركيبها، وتظهر نسبة من الماء في الألياف تتأثر بالظروف البيئية، وتحتوي على الصبغات والبكتين التي توجد بكميات أقل، وتلعب دورًا في معالجة ولون الألياف، ومادة الراتنج الشمعية التي تساهم في حماية الألياف وتحديد خصائصها، ويظهر المقطع الطولي لها على شكل حزم ناعمة أسطوانية الشكل، تمتاز كل إسطوانة بوجود قناة ملئية بالبروتوبلازم، ومحاط بخلايا ليفية منتفخة على مسافات مختلفة من الشعيرة فهي فواصل عرضية إذ تبدو كأنها مقسمة إلى أقسام على طولها تبدو كالقصب المحتوي على مسافات مختلفة، ويظهر المقطع العرضي للألياف مضلع متعدد الأضلاع غير منتظم يتوسطه قناة رفيعة، شكل (12) يوضح القطاع الطولي والعرضي لألياف الكتان تحت المجهر.
            </p>
            <span class="citation-ar">(محمد صبري، 2013 ، ص 32)</span>

            <figure class="my-6 max-w-md mx-auto">
                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="شكل (12): القطاع الطولي والعرضي للكتان تحت المجهر" class="w-full h-auto rounded object-cover" data-desc="شكل (12): القطاع الطولي والعرضي للكتان تحت المجهر" />
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (12) يبين القطاع الطولي والعرضي لالياف الكتان العضوي<br>
                    <span dir="ltr">(Praczyk, M.& et al, 2024, p.7)</span>
                </figcaption>
            </figure>

            <h4 class="font-bold text-gray-700 mt-6 mb-3">مميزات قماش الكتان العضوي:</h4>
            <ul class="list-disc text-gray-800">
                <li>يُعد من أكثر الخامات استدامة لاستخدام القليل من الماء والأسمدة والمواد الكيميائية في زراعته، مقارنة بالكتان التقليدي.</li>
                <li>قابلية امتصاص الرطوبة: يمتص ما يصل إلى 20% من الرطوبة، لذا فهو يستخدم بكثره في فصل الصيف.</li>
                <li>قوة المتانة: يتميز بقوة متانته إذ انه مقاوم للتمزق، مما يجعله قماش يدوم طويلا.</li>
                <li>مضاد للحساسية: يعتبر القماش مضادًا للبكتيريا وصديقا للحساسية بسبب المناخ المحلي الذي ينتجه على الجلد.</li>
                <li>مريح في الارتداء: تعد الملابس الكتانية مريحة في الارتداء، وتتمتع بقدرة على التنفس، يعود ذلك بسبب بنيتها الخفيفة والرقيقة صورة (44) توضح قماش الكتان العضوي، ورمز الاستجابة (5) يستعرض عملية انتاج وتصنيع قماش الكتان العضوي.</li>
            </ul>
            <span class="citation" dir="ltr">(https://www.hausvoneden.com)</span>

            <div class="flex flex-col md:flex-row gap-6 justify-center items-center my-8">
                <figure class="flex-1 max-w-sm">
                    <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (44): قماش الكتان العضوي" class="w-full h-auto rounded object-cover" data-desc="صورة (44): قماش الكتان العضوي" />
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        صورة (44) قماش الكتان العضوي<br>
                        <span dir="ltr">(https://www.amazon.sa)</span>
                    </figcaption>
                </figure>
                <figure class="flex-1 max-w-sm">
                    <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="رمز QR (5)" class="w-full h-auto rounded object-cover" data-desc="رمز QR (5)" />
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        رمز الاستجابة (5) عملية انتاج وتصنيع قماش الكتان
                    </figcaption>
                </figure>
            </div>

            <!-- Hemp Fabric -->
            <div class="mt-12 border-t border-gray-200 pt-8">
                <h4 class="text-lg font-bold text-green-700 mb-2">5. قماش القنب.</h4>
                <p class="text-gray-500 font-sans mb-4" dir="ltr">Hemp fabric</p>
                
                <p>
                    <strong>مفهوم القنب :</strong> يصنف من الألياف النباتية ذات الأصل السليلوزي، وهو من أسرع المصادر الطبيعية نموا، لا يتطلب مبيدات حشرية عند زراعته، كما يعمل على تحسين التربة التي يزرع بها ويعتبر من أفضل الألياف الصديقة للبيئة، فهو غير ملوث للبيئة أثناء دورة حياته، وينمو بدون اسمدة ولا يحتاج إلى مغذيات للتربة، ويتم صناعة النسيج من الياف القنب دون استخدام مواد كيميائية سامة، وهذا مما يجعله قابل للتحلل البيولوجي، صورة (45) تبين نبات القنب، وشكل (13) يوضح شعار نسيج القنب.
                </p>
                <span class="citation">(Antony, R. & Suparna 2016, p.68)</span>

                <div class="flex flex-col md:flex-row gap-6 justify-center items-center my-8">
                    <figure class="w-full md:w-1/4">
                        <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="شكل (13): شعار Organic Hemp Fabric" class="w-full h-auto rounded object-cover" data-desc="شكل (13): شعار Organic Hemp Fabric" />
                        <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                            شكل (13) شعار نسيج القنب<br>
                            <span dir="ltr">(https://www.alamy.com)</span>
                        </figcaption>
                    </figure>
                    <figure class="flex-1">
                        <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (45): نبات القنب (أوراق خضراء)" class="w-full h-auto rounded object-cover" data-desc="صورة (45): نبات القنب (أوراق خضراء)" />
                        <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                            صورة (45) نبات القنب<br>
                            <span dir="ltr">(https://publichealthinsider.com)</span>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <!-- PAGE 16 & 17 -->
        <section class="mb-14">
            <p>
                <strong>استخراج الألياف:</strong> تمر عملية استخراج الألياف بالمرحلة الأولى تسمى "الحصاد"، والتي يتم فيها حصاد المحاصيل من النباتات إذ تقطع على ارتفاع 2 و 3 سم فوق التربة ثم تترك لعدة أيام حتى تجف، ثم تمر بالمرحلة الثانية " النقع" والتي تستخدم فيها الرطوبة لتفكيك الروابط الكيميائية ( البكتين) التي تفصل اللحاء عن اللب الخشبي "القشرة"، يتم تجفيف السيقان وعند اكتمال عملية النقع إلى نسبة اقل من 15% يتم إخراجها من المخزن، وتمر بالمرحلة الأخيرة تسمى "التكسير" إذ تمرر السيقان بآلة تُسمى "مقشرة اللحاء" صورة (46)، والتي يتم فيها فصل الألياف، ثم تمر بالتقشير والتي من خلالها يتم ضرب الألياف لفصل الألياف القصيرة والمادة المتبقية على الألياف الطويلة.
            </p>
            <span class="citation" dir="ltr">(https://hempgazette.com)</span>

            <figure class="my-6 max-w-sm mx-auto">
                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (46): آلة مقشرة اللحاء الخضراء" class="w-full h-auto rounded object-cover" data-desc="صورة (46): آلة مقشرة اللحاء الخضراء" />
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    صورة (46) آلة مقشرة اللحاء<br>
                    <span dir="ltr">(https://arabic.alibaba.com)</span>
                </figcaption>
            </figure>

            <p>
                <strong>تركيب الألياف:</strong> تحتوي الألياف المستخرجة من سيقان النباتات الليفية على السليلوز، والهيميسليلوز، واللجنين والبكتين والشمع والدهون، والرماد، ويظهر القطاع الطولي الألياف على حزم ذات مظهر أملس بسطح خشن، وظهر القطاع العرضي للألياف على حزم ليفية ذات تجويف دقيق الحجم، ويوضح الشكل (14) القطاع الطولي والعرضي للألياف.
            </p>
            <span class="citation">(Awais, H., & et al, 2021, p.3)</span>

            <figure class="my-6 max-w-md mx-auto">
                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="شكل (14): القطاع الطولي والعرضي للقنب" class="w-full h-auto rounded object-cover" data-desc="شكل (14): القطاع الطولي والعرضي للقنب" />
                <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                    شكل (14) يوضح القطاع الطولي والعرضي لألياف القنب<br>
                    <span dir="ltr">(Mwaikambo, L., & Ansell, M. 2003, p.1300)</span>
                </figcaption>
            </figure>

            <h4 class="font-bold text-gray-700 mt-6 mb-3">مميزات قماش القنب:</h4>
            <ul class="list-disc text-gray-800">
                <li>يتميز القنب بقدرته الفائقة على التهوية وتنظيم درجة الحرارة فيحافظ على برودة الجسم صيفا ودفئه شتاءً من خلال حفظ الهواء بين البشرة والملابس وكجميع الأقمشة الطبيعية، بالإضافة الى ان القنب يتميز بقدرته على التحلل الحيوي.</li>
                <li>تعتبر ملابس القنب غير مكلفة مقارنةً بالأقمشة التقليدية الأخرى كالقطن والصوف.</li>
                <li>يزرع القنب من مواد طبيعية لا تحتاج إلى معالجة كيميائية أو صبغات، لذا فإن الملابس المصنوعة من القنب تعتبر خيارًا أفضل.</li>
                <li>قدرته العالية على امتصاص الرطوبة، لذا يتمتع بالقدرة على امتصاص ما يصل إلى 4 أضعاف وزنه من الماء دون أن يبتل. ثم يطلق الرطوبة ببطء مرة أخرى، مع إمكانية ان يجف بسرعة.</li>
                <li>مضاد للميكروبات اذ ان ألياف القنب قادرة على محاربة البكتيريا والميكروبات من تلقاء نفسها بسبب المواد الكيميائية النباتية الموجودة به وهذا ما يجعله خيار انسب لأصحاب البشرة الحساسة.</li>
                <li>تتميز أقمشة القنب بمتانتها الفائقة، مما يجعله خيارًا مثاليًا للملابس التي تتعرض للكثير من التآكل والتلف، كما أنه استخدم سابقًا في صناعة أشرعة السفن اذ يرجع ذلك بسبب متانته العالية.</li>
                <li>مقاومته للتمزق وذلك يجعله مثاليًا للملابس الرياضية، كما توضح صورة (47) قماش القنب الصديق للبيئة، ورمز الاستجابة (6) يوضح عملية انتاج وتصنيع قماش القنب.</li>
            </ul>
            <span class="citation" dir="ltr">(https://ecentric.in)</span>

            <div class="flex flex-col md:flex-row gap-6 justify-center items-center my-8">
                <figure class="flex-1 max-w-sm">
                    <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (47): قماش القنب الصديق للبيئة" class="w-full h-auto rounded object-cover" data-desc="صورة (47): قماش القنب الصديق للبيئة" />
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        صورة (47) قماش القنب الصديق للبيئة<br>
                        <span dir="ltr">(https://aradbranding.com)</span>
                    </figcaption>
                </figure>
                <figure class="flex-1 max-w-sm">
                    <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="رمز QR (6)" class="w-full h-auto rounded object-cover" data-desc="رمز QR (6)" />
                    <figcaption class="text-center mt-3 text-sm font-sans text-gray-600">
                        رمز الاستجابة (6) عملية انتاج وتصنيع قماش القنب
                    </figcaption>
                </figure>
            </div>
        </section>

        <!-- PAGE 17 & 18 & 19 -->
        <section class="mb-14 border-t border-gray-200 pt-8">
            <h3 class="text-xl font-bold text-gray-700 mb-2">الشروط الواجب توافرها في الأقمشة المستدامة "الصديقة للبيئة" :</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">Conditions for environmentally friendly fabrics:</h4>
            <p>
                تصنع الأقمشة الصديقة للبيئة وتصمم وفقا لمجموعة من المعايير التي تهدف إلى حماية البيئة والتقليل من استنزاف الموارد الطبيعية، مع الحفاظ على خصائص الأداء الأصلية، ومن أهم المعايير الواجب توافرها في الأقمشة والخامات الصديقة للبيئة ما يلي:
            </p>
            <ul class="list-disc text-gray-800">
                <li>ان تكون متوفرة محليا.</li>
                <li>ان تكون قابلة للتحلل بيولوجيا.</li>
                <li>عمرها الاستهلاكي طويل الأجل.</li>
                <li>قابلة لإعادة التدوير وإعادة الاستخدام.</li>
            </ul>
            <span class="citation-ar">(ياسمين بازید، 2022، ص 652)</span>

            <h3 class="text-xl font-bold text-gray-700 mt-10 mb-2">فوائد الاقمشة المستدامة "الصديقة للبيئة" :</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">Benefits of sustainable fabrics</h4>
            <ol class="list-decimal text-gray-800">
                <li>التقليل من الهدر في المواد والطاقة والحد من الآثار السلبية.</li>
                <li>تمييز المنتج المقدم من قبل الشركة أو المؤسسة عن منتجات المنافسين.</li>
                <li>إعطاء سمعة بيئية جيدة للمنظمة وقابلية لاستمرارية نشاطها.</li>
                <li>تصميم وتطوير أزياء امنة ومناسبة للبيئة.</li>
                <li>تخفيض التكاليف الإنتاجية عبر أسس التطوير البيئي. <span class="citation-ar inline mr-2">(نبيلة الفراج، 2025، ص 100)</span></li>
            </ol>

            <h3 class="text-xl font-bold text-gray-700 mt-10 mb-2">خصائص الاقمشة المستدامة "الصديقة للبيئة" :</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">Properties of environmentally friendly fabrics:</h4>
            <ul class="list-disc text-gray-800">
                <li>اقمشة غير مصنوعة من مكونات ضارة بطبقة الأوزون أو شديدة السمية، او مواد خطرة مثل المواد الحافظة الكيماوية والنووية، تعني ان الطاقة المستخدمة في إنتاجها قليلة.</li>
                <li>تنتج من مواد معاد تدويرها، مما يعني ان ذات الموارد سوف تستخدم من أجل إنتاج العديد من المنتجات، حيث فلا تحدث مواردها ومخلفاتها بأي شكل ضررًا للبيئة</li>
                <li>إعادة تصنيعها من منتجات تم التخلص منها، حيث لا تحدث مواردها ومخلفاتها بأي شكل ضررًا، مما يساهم ذلك في المحافظة على الموارد والمصادر الطبيعية.</li>
                <li>تأثر الاقمشة والخامات الصديقة للبيئة تأثيراً امنا على البيئة إذ انها لا تسبب مواد ضارة عند الاستخدام، ولا تسبب انبعاثات سامة عند التخلص منها.</li>
                <li>أمنة على صحة الانسان أي لا ينتج عنها ضرر أو تأثير سلبي.</li>
            </ul>
            <span class="citation-ar">(أماني شاهين وآخرون، 2021، ص 168)</span>

            <h3 class="text-xl font-bold text-gray-700 mt-10 mb-2">مميزات الاقمشة المستدامة "الصديقة للبيئة" :</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">Advantages of sustainable "eco-friendly" fabrics:</h4>
            <ol class="list-decimal text-gray-800">
                <li><strong>الموارد الطبيعية:</strong> تعتمد على الالياف الطبيعية مثل القطن والكتان المزروعة بدون مبيدات حشرية أو اسمدة كيميائية.</li>
                <li><strong>التجديد:</strong> تعتمد على موارد قابل لتجديد كالأشجار والنباتات.</li>
                <li><strong>الأمان للبشرة:</strong> خلوها من المواد الكيميائية الضارة يجعلها آمنة على البشرة.</li>
                <li><strong>قابليتها للتحلل:</strong> تتحلل بيولوجيا دون ان تترك خلفها أثرًا ضارًا على البيئة.</li>
                <li><strong>الاستدامة:</strong> تنتج بطريقة تقلل من استنزاف المياه والطاقة.</li>
                <li><strong>تقنيات التصنيع نظيفة:</strong> تتطلب عمليات التصنيع استخدامًا اقل للمواد الكيميائية الضارة وتكون أقل تلوث.</li>
                <li><strong>التحكم في انبعاثات الكربون:</strong> تنتج من تقنيات تقلل من انبعاثات الكربون.</li>
            </ol>
            <span class="citation-ar">(هدى السيد، وريم الحربي، 2024 ، ص 2448)</span>
        </section>

        <!-- PAGE 19 & 20 -->
        <section class="mb-14 border-t border-gray-200 pt-8">
            <h3 class="text-xl font-bold text-gray-700 mb-4">خطوات عملية التصميم على الاقمشة (من الفكرة إلى الإنتاج):</h3>
            <ol class="list-decimal text-gray-800">
                <li><strong>الإلهام والبحث:</strong> يجمع المصمم صورًا من الطبيعة، الفن، الموضة، التاريخ، الأقمشة القديمة، الألوان الرائجة الملمس، الضوء، اذ ان هذه المرحلة تعتبر من المراحل المهمة جدا لإعطاء التصميم شكل خاص وهوية.</li>
                <li><strong>التصور والمفاهيم:</strong> يتم في هذه المرحلة رسم أفكارًا مبدئية (سكيتشات أو رسومات أولية) أو العمل بمخططات التكوين (composition)، كما يمكن استخدام لوحات (mood boards) لتجميع الألوان والأنماط، والاستلهام البصري.</li>
                <li><strong>التنفيذ والتحويل الرقمي:</strong> في هذه المرحلة يحوّل الرسم اليدوي إلى شكل رقمي باستخدام برامج التصميم الرقمية مثل Adobe Illustrator أو Photoshop أو برامج متخصصة بالأجهزة اللوحية كبرنامج Procreate.</li>
                <li><strong>التكرار (Repeat / Seamless Pattern Creation):</strong> لأن القماش يطبع أو يُنسج في وحدة كبيرة، يجب أن يكون التصميم قابلاً للتكرار بشكل سلس متواصل فواصل ظاهرة.</li>
                <li><strong>اختيار الألوان (Colorways):</strong> فيها يتم اختيار تدرّجات لونية متعددة للتصميم الواحد (کنسخة بالألوان الهادئة، ونسخة بالألوان الزاهية).</li>
                <li><strong>إعداد العينات (Samples / Strike-offs / Swatches):</strong> ينتج المصمم عينات صغيرة من التصميم على القماش ليُقيم النتيجة الحقيقية في الواقع (كيف تظهر الألوان فعليا على القماش).</li>
                <li><strong>التعديلات والتكرار النهائي:</strong> بعد مراجعة العينات، قد تُجرى تعديلات على الألوان، كثافة التصميم، أو ترتيب العناصر.</li>
                <li><strong>الإنتاج النهائي:</strong> يُرسل التصميم إلى المصنع لإنتاج القماش بكميات كبيرة، مع المتابعة لضمان الجودة والمطابقة.</li>
            </ol>
            <span class="citation" dir="ltr">(https://www.istitutomarangonimiami.com)</span>

            <h3 class="text-xl font-bold text-gray-700 mt-10 mb-4">أنواع التصميم على الأقمشة:</h3>
            <p>هناك عدة تقنيات وتصميمات معينة تُستخدم في صناعة الأقمشة، منها:</p>
            <ul class="list-disc text-gray-800">
                <li><strong>التصميم المطبوع (Printed Textile Design):</strong> يُطبع النمط على سطح القماش بعد أن يتم استيراد التصميم الرقمي، ويمكن تنفيذه باستخدام تقنيات كالطباعة بالشاشة (Screen Printing) أو الطباعة الرقمية أو التسامي (Sublimation)</li>
                <li><strong>التصميم المنسوج (Woven / Jacquard):</strong> تكون الزخرفة جزءًا من النسج نفسه، أي تنسج الخيوط بحيث تشكل الأنماط دون طبعة إضافية، هذا يتطلب معرفة تكنولوجيا النسيج والمكائن.</li>
                <li><strong>التصميم مختلط / تزيين (Mixed Media / Surface Decoration):</strong> مثلاً استخدام التطريز، الزخرفة اليدوية، الطلاء، الحرق الكيميائي (مثل تقنية Devore).</li>
                <li><strong>تقنيات متقدمة / رقمية:</strong> مع التقدم التكنولوجي أصبح بعض المصممين يستخدمون الطباعة الرقمية على القماش أو البرمجة لتوليد أنماط أو تأثيرات خاصة.</li>
            </ul>
            <span class="citation">(Wilson, J., 2001, p.106-117)</span>
        </section>

        <!-- PAGE 20 & 21 & 22 & 23 -->
        <section class="mb-8 border-t border-gray-200 pt-8">
            <h3 class="text-xl font-bold text-gray-700 mb-2">أثر الاقمشة الصديقة للبيئة على العلامات التجارية</h3>
            <h4 class="text-lg text-gray-500 mb-3 font-sans" dir="ltr">The Impact of Eco-Friendly Fabrics on Brands:</h4>
            <p>
                تسعى الشركات الحديثة إلى تعزيز صورتها أمام المستهلكين من خلال الالتزام بالمعايير البيئية والاجتماعية، إلا أن تطبيق الاستدامة يواجه تحديات أبرزها ارتفاع تكلفة الإنتاج المستدام وضعف وعي المستهلكين البيئي، إلى جانب محدودية استعدادهم لدفع أسعار عالية مقابل منتجات صديقة للبيئة، وعلى الرغم من الجهود المبذولة لا يزال كثير من المستهلكين يركزون على الجوانب الجمالية للمنتج دون الالتفات إلى أبعاده البيئية، مما يُضعف الإقبال على الأزياء المستدامة، ومع تطور المعرفة والتكنولوجيا من الضروري اعتماد استراتيجيات توعوية تسهم في تغيير سلوك المستهلك، اذ بدأت بعض الشركات بتبني ممارسات مستدامة تشمل استخدام خامات طبيعية وتقليل المواد الضارة، وإعادة تصميم أنظمة الإنتاج بما يقلل من البصمة الكربونية، وتشير هذه المبادرات إلى تنامي الوعي بأهمية التحول نحو حلول مستدامة، بما يلبي متطلبات المستهلك المعاصر ويواكب المعايير العالمية في صناعة الأزياء، وجدول (2) يستعرض بعض الشركات التي صنعت منتجاتها من الخامات والاقمشة الصديقة للبيئة.
            </p>
            <span class="citation-ar">(2025: _ , 128)</span>
            
            <p class="font-bold text-gray-700 my-4 text-center">جدول (2) يستعرض العلامات التجارية التي اتخذت الاقمشة المستدامة في صناعة منتجاتها:</p>

            <div class="overflow-x-auto my-6">
                <table>
                    <thead>
                        <tr>
                            <th class="w-1/4">العلامة التجارية</th>
                            <th class="w-1/2">الوصف</th>
                            <th class="w-1/4 text-center">صورة المنتج</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Stella McCartney -->
                        <tr>
                            <td class="font-bold">ستيلا مكارتني<br><span dir="ltr">Stella McCartney</span></td>
                            <td>
                                تستخدم ستيلا مكارتني القطن العضوي والبوليستر المعاد تدويره والأحذية القابلة للتحلل الحيوي والأسيتات الحيوية في منتجاتها، وتسعى جاهده الى تطوير العديد من البدائل الصديقة للبيئة كالجلود المصنوعة من العنب، كما تعتبر ستيلا مكارتني من أوائل المصممين الذين تبنوا الاستدامة في الأزياء الفاخرة.
                            </td>
                            <td class="text-center">
                                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (48) تصميم ستيلا مكارتني" class="w-full h-auto rounded object-cover" data-desc="صورة (48) تصميم ستيلا مكارتني" />
                                <span class="text-xs text-gray-600">تصميم من علامة ستيلا مكارتني مصنوع من البولسيتر المعاد تدويره</span><br>
                                <span class="text-[10px] text-gray-500 block mt-1" dir="ltr">(https://www.stellamccartney.com)</span>
                            </td>
                        </tr>
                        <!-- Ecoalf -->
                        <tr>
                            <td class="font-bold" dir="ltr">-Ecoalf:</td>
                            <td>
                                تأسست عام 2009 في اسبانيا، تمثل نموذج مبتكر في عالم الموضة المستدامة، تسعى جاهدة الى إعادة تدوير نفايات المحيطات وهو المشروع الرئيسي لها اذ تستخدم في تنفيذ منتجاتها المواد البلاستيكية وشباك الصيد المتراكمة في قاع البحر، لجعلها تصاميم معاصرة عالية الجودة.
                            </td>
                            <td class="text-center">
                                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (49) تصميم Ecoalf" class="w-full h-auto rounded object-cover" data-desc="صورة (49) تصميم Ecoalf" />
                                <span class="text-xs text-gray-600">تصميم من Ecoalf مصنوع من 50% بوليستر معاد تدويره و 50% قطن عضوي</span><br>
                                <span class="text-[10px] text-gray-500 block mt-1" dir="ltr">(https://ecoalf.com)</span>
                            </td>
                        </tr>
                        <!-- H&M -->
                        <tr>
                            <td class="font-bold">-H&M:<br><span dir="ltr">Conscious</span></td>
                            <td>
                                أطلقت شركة H&M سلسلة “ Conscious Collection" كجزء من التزامها بالاستدامة، حيث تستخدم فيها أقمشة مستدامة مثل القطن العضوي والبوليستر المعاد تدويره، وتينسيل، وقد وضعت أهدافًا طويلة المدى لاستخدام المواد المستدامة بنسبة 100% في منتجاتها.
                            </td>
                            <td class="text-center">
                                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (50) جاكيت H&M" class="w-full h-auto rounded object-cover" data-desc="صورة (50) جاكيت H&M" />
                                <span class="text-xs text-gray-600">جاكيت صديقة للبيئة من H&M</span><br>
                                <span class="text-[10px] text-gray-500 block mt-1" dir="ltr">(https://sa.hm.com)</span>
                            </td>
                        </tr>
                        <!-- Adidas -->
                        <tr>
                            <td class="font-bold">اديداس<br><span dir="ltr">Adidas</span></td>
                            <td>
                                أدخلت شركة أديداس أقمشة صديقة للبيئة ضمن منتجاتها الرياضية، وتعاونت مع منظمة “ Parley for the Oceans" لإنتاج أحذية وملابس مصنوعة من نفايات البلاستيك التي تجمع من المحيطات وتم إعادة تدويرها، كما تسعى الشركة إلى استخدام البوليستر المعاد تدويره بنسبة 100% في جميع منتجاتها بحلول عام 2024.
                            </td>
                            <td class="text-center">
                                <img src="{{ asset("images/fabric/img/fabrics-01.jpg") }}" alt="صورة (51) تصميم اديداس" class="w-full h-auto rounded object-cover" data-desc="صورة (51) تصميم اديداس" />
                                <span class="text-xs text-gray-600">تصميم صديق للبيئة من اديداس</span><br>
                                <span class="text-[10px] text-gray-500 block mt-1" dir="ltr">(https://www.adidas.sa)</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p class="mb-4">من خلال ما سبق توصلت الباحثة الى الفرق بين الاقمشة الصديقة للبيئة والاقمشة التقليدية، وفيما يلي عرض لذلك:</p>

            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th class="w-1/4">وجه المقارنة</th>
                            <th class="w-2/5">الأقمشة الصديقة للبيئة</th>
                            <th class="w-2/5">الاقمشة التقليدية</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-bold">المواد الخام<br><br>استهلاك الموارد<br><br>التأثير البيئي</td>
                            <td>
                                تعتمد على مواد طبيعية متجددة أو معاد تدويرها<br><br>
                                تستخدم تقنيات تقلل استهلاك الموارد كالماء والطاقة<br><br>
                                تقلل التلوث باستخدام مواد آمنة وأصباغ طبيعية
                            </td>
                            <td>
                                تعتمد على الياف صناعية أو زراعة مكثفة كيميائيا<br><br>
                                تستهلك كميات كبيرة من الماء<br><br>
                                تسبب تلوثا للمياه والتربة نتيجة المواد الكيميائية الطاقة
                            </td>
                        </tr>
                        <tr>
                            <td class="font-bold">القابلية للتحلل</td>
                            <td>قابلة للتحلل الحيوي وإعادة التدوير</td>
                            <td>غير قابلة للتحلل</td>
                        </tr>
                        <tr>
                            <td class="font-bold">جودة الاستخدام</td>
                            <td>توفر راحة وتهوية عالية مناسبة للبشرة الحساسة" آمنة للبشرة"</td>
                            <td>أكثر مرونة</td>
                        </tr>
                        <tr>
                            <td class="font-bold">التكلفة<br><br>العيوب</td>
                            <td>
                                أعلى تكلفة نسبيًا بسبب تقنيات الإنتاج المستدام<br><br>
                                ارتفاع التكلفة، محدودية الأنواع في الأسواق، تحتاج عناية خاصة
                            </td>
                            <td>
                                أقل تكلفة في الإنتاج والشراء<br><br>
                                تلوث بيئي مرتفع، غير قابلة للتحلل تسبب حساسية البشرة
                            </td>
                        </tr>
                        <tr>
                            <td class="font-bold">المميزات</td>
                            <td>تقلل من التلوث البيئي، الحفاظ على الموارد الطبيعية، أمان صحي للإنسان، قابليتها للتحلل وإعادة التدوير</td>
                            <td>انخفاض التكلفة، توفر واسع في الأسواق، متانة ومقاومة للتجاعيد</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>

    
            </div>
    </section>

    <!-- Lightbox -->
    <div id="technique-lightbox" class="technique-lightbox">
        <button class="lb-close" id="lb-close" aria-label="إغلاق">&times;</button>
        <div class="lb-image-wrap">
            <img id="lb-image" src="" alt="">
            <div id="lb-caption" class="lb-caption"></div>
        </div>
    </div>

@push("styles")
<style>

        body {
            font-family: 'Amiri', serif;
            background-color: #f4f7f6;
            color: #333;
        }
        h1, h2, h3, h4, th, .font-sans {
            font-family: 'Tajawal', sans-serif;
        }
        p {
            text-align: justify;
            line-height: 2.2;
            margin-bottom: 1.25rem;
            font-size: 1.125rem;
        }
        .citation {
            color: #6b7280;
            font-size: 0.95rem;
            display: block;
            margin-top: -0.75rem;
            margin-bottom: 1.5rem;
            text-align: left;
            direction: ltr;
        }
        .citation-ar {
            color: #6b7280;
            font-size: 0.95rem;
            display: block;
            margin-top: -0.75rem;
            margin-bottom: 1.5rem;
        }
        ul, ol {
            padding-right: 1.5rem;
            margin-bottom: 1.5rem;
            line-height: 2;
            font-size: 1.125rem;
        }
        li {
            margin-bottom: 0.75rem;
        }
        .image-placeholder {
            background: #e5e7eb;
            border: 2px dashed #9ca3af;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            overflow: hidden;
            position: relative;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 2rem;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 1rem;
            text-align: right;
            vertical-align: top;
        }
        th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
    
</style>
@endpush

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

        // ── Lightbox ──────────────────────────────────────────────
        const lb         = document.getElementById('technique-lightbox');
        const lbImg      = document.getElementById('lb-image');
        const lbCaption  = document.getElementById('lb-caption');
        const lbClose    = document.getElementById('lb-close');

        function openLightbox(src, caption) {
            lbImg.src = src;
            lbCaption.textContent = caption;
            lb.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lb.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Click on any article image
        document.querySelectorAll('.article-content figure img').forEach(img => {
            img.addEventListener('click', function(e) {
                e.stopPropagation();
                const fig = this.closest('figure');
                const cap = fig ? fig.querySelector('figcaption') : null;
                const caption = cap ? cap.textContent.trim().replace(/\s+/g, ' ') : '';
                openLightbox(this.src, caption);
            });
        });

        // Close handlers
        lbClose.addEventListener('click', closeLightbox);
        lb.addEventListener('click', function(e) {
            if (e.target === this) closeLightbox();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
        });

        // ── Fallback for broken images ────────────────────────────
        document.querySelectorAll('.article-content figure img').forEach(img => {
            img.addEventListener('error', function() {
                if (!this.dataset.fallbackShown) {
                    this.dataset.fallbackShown = '1';
                    this.style.display = 'none';
                    const fig = this.closest('figure');
                    if (fig && !fig.querySelector('.img-fallback')) {
                        const fallback = document.createElement('div');
                        fallback.className = 'img-fallback';
                        fallback.innerHTML = '<div class="flex flex-col items-center justify-center py-12 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300"><svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg><span class="text-gray-500 font-sans font-bold text-sm">الصورة غير متوفرة بعد</span></div>';
                        fig.insertBefore(fallback, fig.querySelector('figcaption'));
                    }
                }
            });
        });
    });
</script>
@endpush
