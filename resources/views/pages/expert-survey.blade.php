@extends('layouts.app')
@section('title', 'استمارة تحكيم المتخصصين')
@section('content')
<div class="w-full mx-auto max-w-5xl px-4 mt-8 space-y-12 pb-12" dir="rtl">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 sm:p-12">
        <!-- الترويسة -->
        <div class="flex flex-col sm:flex-row justify-between items-center border-b-2 border-qassim pb-6 mb-8">
            <div class="text-center sm:text-right font-semibold leading-relaxed">
                <p>المملكة العربية السعودية</p>
                <p>وزارة التعليم</p>
                <p>جامعة القصيم</p>
                <p>كلية الفنون والتصاميم</p>
                <p>قسم تصميم أزياء</p>
            </div>
            <div class="mt-4 sm:mt-0 text-center flex flex-col items-center">
                <div class="w-24 h-24 rounded-full border-4 border-qassim flex items-center justify-center mb-2">
                    <span class="text-qassim font-bold text-sm text-center">جامعة القصيم<br>Qassim Univ</span>
                </div>
                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-bold border border-gray-200">ملحق رقم (9، 10)</span>
            </div>
        </div>

        <div class="text-center mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-qassim mb-4">استمارة تحكيم المتخصصين لصلاحية التطبيق للنشر على المتجر</h2>
        </div>

        <div class="prose max-w-none mb-8 text-gray-700 leading-8 text-justify">
            <p>تحية طيبة وبعد ،،،</p>
            <p>
                تقوم الباحثة / <strong>ريم علي السعوي</strong> بإجراء دراسة لاستكمال متطلبات الحصول على درجة الماجستير في تصميم الأزياء مسار تصميم وتطريز الملابس والمنسوجات بعمل بحث بعنوان: 
                <span class="text-qassim font-bold">"ابتكار تطبيق ذكي للتصميم على الاقمشة الصديقة للبيئة ذات النقشة الزائدة والمستلهمة من الاعمال التشكيلية للفنان وليام موريس لتفعيل الاستدامة"</span>
            </p>
            <p>
                قامت الباحثة بإعداد تطبيق ذكي للتصميم على الاقمشة الصديقة للبيئة ذات النقشة الزائدة، ولذلك تم إعداد هذه الاستمارة بهدف معرفة مدى صلاحية التطبيق للنشر على المتجر، والمرجو من سيادتكم التفضل بقراءة محاورها وبنودها وإبداء الرأي في مدى صحتها، وإضافة ما ترونه غير واضح أو محدد، أو حذف ما ترونه غير مناسب.
            </p>
            <p class="mt-4 font-bold">ولسيادتكم جزيل الشكر لتعاونكم ،،،</p>
        </div>

        <form action="{{ route('expert.survey.post') }}" method="POST">
            @csrf
            <div class="mb-6 flex flex-col gap-2">
                <label class="font-bold text-lg mb-2">السيد الأستاذ الدكتور /</label>
                <input type="text" name="evaluator_name" class="w-full border-b-2 border-dashed border-gray-400 p-2 outline-none focus:border-qassim bg-transparent" placeholder="الاسم (اختياري)">
            </div>

            <div class="mt-8 space-y-10">
                @php
                    $part1 = [
                        "صحة المعلومات العلمية التي يتضمنها التطبيق.",
                        "التسلسل المنطقي في عرض المحتوى وتوضيحه.",
                        "وضوح أهداف التطبيق.",
                        "وضوح الصياغة اللغوية.",
                        "ملائمة التطبيق لمستوى المتعلم.",
                        "وضوح ومناسبة مشاهد الفيديو للمعلومة المصاحبة.",
                        "وضوح ومناسبة الصور الثابتة من رسوم وأشكال للمعلومة المناسبة.",
                        "سهولة استيعابه وخلوه من العبارات الغامضة والتعقيدات اللغوية."
                    ];
                @endphp
                <div class="space-y-4">
                    <h3 class="bg-gray-100 p-4 rounded-xl font-bold text-green-800 border border-gray-200 shadow-sm text-lg">أولاً: معايير التصميم التعليمي للتطبيق</h3>
                    @foreach($part1 as $index => $item)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 sm:p-6 shadow-sm flex flex-col lg:flex-row lg:items-center gap-4 hover:border-green-400 hover:shadow-md transition-all">
                        <div class="flex-1 flex items-start gap-3">
                            <span class="shrink-0 inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100 text-green-800 text-sm font-bold">{{ $index + 1 }}</span>
                            <span class="font-semibold text-gray-800 leading-relaxed pt-0.5">{{ $item }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2 lg:shrink-0 lg:w-auto mt-2 lg:mt-0">
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="q1_{{ $index+1 }}" value="3" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-4 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition-all select-none shadow-sm">
                                    متوافر (3)
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="q1_{{ $index+1 }}" value="2" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-4 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-yellow-500 peer-checked:text-white peer-checked:border-yellow-500 transition-all select-none shadow-sm">
                                    إلى حد ما (2)
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="q1_{{ $index+1 }}" value="1" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-4 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500 transition-all select-none shadow-sm">
                                    غير متوافر (1)
                                </div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>

                @php
                    $part2 = [
                        "سهولة تحميل التطبيق من المتجر.",
                        "أيقونة التطبيق جميلة وجذابة.",
                        "تعكس أيقونة التطبيق وظيفة التطبيق.",
                        "وجود صور داخل واجهة التطبيق.",
                        "توزيع الألوان على الشاشة وتناسبها مع بعضها البعض.",
                        "حجم حروف الكتابة ووضوحها على الشاشة."
                    ];
                @endphp
                <div class="space-y-4">
                    <h3 class="bg-gray-100 p-4 rounded-xl font-bold text-green-800 border border-gray-200 shadow-sm text-lg">ثانياً: صحة وملائمة المحتوى العلمي والفني</h3>
                    @foreach($part2 as $index => $item)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 sm:p-6 shadow-sm flex flex-col lg:flex-row lg:items-center gap-4 hover:border-green-400 hover:shadow-md transition-all">
                        <div class="flex-1 flex items-start gap-3">
                            <span class="shrink-0 inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100 text-green-800 text-sm font-bold">{{ $index + 9 }}</span>
                            <span class="font-semibold text-gray-800 leading-relaxed pt-0.5">{{ $item }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2 lg:shrink-0 lg:w-auto mt-2 lg:mt-0">
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="q2_{{ $index+9 }}" value="3" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-4 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition-all select-none shadow-sm">
                                    متوافر (3)
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="q2_{{ $index+9 }}" value="2" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-4 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-yellow-500 peer-checked:text-white peer-checked:border-yellow-500 transition-all select-none shadow-sm">
                                    إلى حد ما (2)
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="q2_{{ $index+9 }}" value="1" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-4 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500 transition-all select-none shadow-sm">
                                    غير متوافر (1)
                                </div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>

                @php
                    $part3 = [
                        "درجة وضوح ونقاء مشاهد الفيديو عند العرض.",
                        "درجة وضوح الصور الثابتة والمتحركة أثناء العرض.",
                        "درجة وضوح الصوت."
                    ];
                @endphp
                <div class="space-y-4">
                    <h3 class="bg-gray-100 p-4 rounded-xl font-bold text-green-800 border border-gray-200 shadow-sm text-lg">ثالثاً: تنفيذ التطبيق بصورة سليمة</h3>
                    @foreach($part3 as $index => $item)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 sm:p-6 shadow-sm flex flex-col lg:flex-row lg:items-center gap-4 hover:border-green-400 hover:shadow-md transition-all">
                        <div class="flex-1 flex items-start gap-3">
                            <span class="shrink-0 inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100 text-green-800 text-sm font-bold">{{ $index + 15 }}</span>
                            <span class="font-semibold text-gray-800 leading-relaxed pt-0.5">{{ $item }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2 lg:shrink-0 lg:w-auto mt-2 lg:mt-0">
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="q3_{{ $index+15 }}" value="3" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-4 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition-all select-none shadow-sm">
                                    متوافر (3)
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="q3_{{ $index+15 }}" value="2" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-4 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-yellow-500 peer-checked:text-white peer-checked:border-yellow-500 transition-all select-none shadow-sm">
                                    إلى حد ما (2)
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="q3_{{ $index+15 }}" value="1" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-4 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500 transition-all select-none shadow-sm">
                                    غير متوافر (1)
                                </div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>

                @php
                    $part4 = [
                        "يساعد الطالب على التعلم ذاتياً.",
                        "يعرض المحتوى في خطوات متتابعة متسلسلة منطقيا تناسب الطالب.",
                        "يتيح للمتعلم التحكم في اختيار المحتوى أو جزء منه.",
                        "يتيح للمتعلم تكرار تعلم ومشاهدة أي جزء من الفيديوهات داخل التطبيق بسهولة ويسر.",
                        "يتيح للمتعلم الخروج من التطبيق في أي وقت شاء.",
                        "سهولة التنقل عبر شاشات التطبيق باستخدام الأزرار أو المفاتيح.",
                        "يساعد الطالب على التقويم الذاتي.",
                        "يتيح الفرصة لكل طالب للتعلم وفقاً لقدراته وسرعته.",
                        "يوفر التطبيق عناصر الجذب والتشويق.",
                        "يسمح للطالب بمراجعة الأطر التي سبق له دراستها."
                    ];
                @endphp
                <div class="space-y-4">
                    <h3 class="bg-gray-100 p-4 rounded-xl font-bold text-green-800 border border-gray-200 shadow-sm text-lg">رابعاً: سهولة تعامل الطالب مع التطبيق وصلاحيته</h3>
                    @foreach($part4 as $index => $item)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 sm:p-6 shadow-sm flex flex-col lg:flex-row lg:items-center gap-4 hover:border-green-400 hover:shadow-md transition-all">
                        <div class="flex-1 flex items-start gap-3">
                            <span class="shrink-0 inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100 text-green-800 text-sm font-bold">{{ $index + 18 }}</span>
                            <span class="font-semibold text-gray-800 leading-relaxed pt-0.5">{{ $item }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2 lg:shrink-0 lg:w-auto mt-2 lg:mt-0">
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="q4_{{ $index+18 }}" value="3" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-4 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition-all select-none shadow-sm">
                                    متوافر (3)
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="q4_{{ $index+18 }}" value="2" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-4 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-yellow-500 peer-checked:text-white peer-checked:border-yellow-500 transition-all select-none shadow-sm">
                                    إلى حد ما (2)
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="q4_{{ $index+18 }}" value="1" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-4 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500 transition-all select-none shadow-sm">
                                    غير متوافر (1)
                                </div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex flex-col gap-4">
                    <label class="font-bold text-gray-800">ملاحظات / تعديلات مقترحة:</label>
                    <textarea name="notes" class="w-full border border-gray-300 rounded-lg p-4 focus:ring-2 focus:ring-green-600 focus:border-green-600 outline-none transition" rows="4" placeholder="اكتب ملاحظاتك هنا..."></textarea>
                </div>
            </div>

            <div class="mt-8 text-center">
                <button type="submit" style="background-color: #166534" class="text-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-green-800 transition-colors shadow-md">إرسال التقييم</button>
            </div>
        </form>
    </div>
</div>
@endsection
