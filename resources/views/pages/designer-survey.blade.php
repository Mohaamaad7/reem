@extends('layouts.app')
@section('title', 'استمارة تحكيم المصممين')
@section('content')
<div class="w-full mx-auto max-w-5xl px-4 mt-8 space-y-12 pb-12" dir="rtl">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 sm:p-12 mb-12">
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
                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-bold border border-gray-200">ملحق رقم (11)</span>
            </div>
        </div>

        <div class="text-center mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-qassim mb-4">استمارة تحكيم مصممي الأقمشة داخل مصانع الملابس لصلاحية التطبيق الذكي للتصميم على الأقمشة</h2>
        </div>

        <form action="{{ route('designer.survey.post') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 bg-green-50 p-6 rounded-lg border border-green-100">
                <div class="flex flex-col gap-2">
                    <label class="font-bold text-green-900">إسم المصمم:</label>
                    <input type="text" name="designer_name" required class="border border-gray-300 rounded-md p-2 outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 bg-white" placeholder="ادخل اسم المصمم...">
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-bold text-green-900">المصنع:</label>
                    <input type="text" name="factory_name" required class="border border-gray-300 rounded-md p-2 outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 bg-white" placeholder="ادخل اسم المصنع...">
                </div>
            </div>
            
            <p class="font-bold text-gray-700 mb-4">ضع علامة (✓) أسفل الاستجابة التي تتفق مع وجهة نظرك في كل من العبارات الآتية:</p>

            <div class="mt-8 space-y-10">
                {{-- المحور الأول: جودة المحتوى والتعلم --}}
                @php
                    $axis1 = [
                        "وضوح أهداف التطبيق.",
                        "ساعدني التطبيق على التعلم بسهولة في أي وقت.",
                        "ساعدني التطبيق على التعلم بسهولة في أي مكان.",
                        "المادة العلمية للتطبيق المقترح منظمة بشكل منطقي.",
                        "يحتوي التطبيق على عدد كافٍ من الأشكال والصور التوضيحية.",
                    ];
                @endphp
                <div class="space-y-4">
                    <h3 class="bg-gray-100 p-4 rounded-xl font-bold text-green-800 border border-gray-200 shadow-sm text-lg">المحور الأول: جودة المحتوى والتعلم</h3>
                    @foreach($axis1 as $index => $item)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 sm:p-6 shadow-sm flex flex-col lg:flex-row lg:items-center gap-4 hover:border-green-400 hover:shadow-md transition-all">
                        <div class="flex-1 flex items-start gap-3">
                            <span class="shrink-0 inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100 text-green-800 text-sm font-bold">{{ $index + 1 }}</span>
                            <span class="font-semibold text-gray-800 leading-relaxed pt-0.5">{{ $item }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2 lg:shrink-0 lg:w-auto mt-2 lg:mt-0">
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="f2_{{ $index+1 }}" value="1" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-5 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition-all select-none shadow-sm">
                                    متوفر
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="f2_{{ $index+1 }}" value="0" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-5 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500 transition-all select-none shadow-sm">
                                    غير متوفر
                                </div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- المحور الثاني: الفائدة المهنية والتطبيقية --}}
                @php
                    $axis2 = [
                        "يلبي التطبيق الاحتياجات الفعلية لدى المهتمين بالتصميم على الأقمشة.",
                        "يسهم التطبيق في تحسين مستوى الأداء في التصميم على الأقمشة.",
                        "يعد التطبيق المقترح أحد الأساليب الحديثة لتعلم التصميم على الأقمشة.",
                    ];
                @endphp
                <div class="space-y-4">
                    <h3 class="bg-gray-100 p-4 rounded-xl font-bold text-green-800 border border-gray-200 shadow-sm text-lg">المحور الثاني: الفائدة المهنية والتطبيقية</h3>
                    @foreach($axis2 as $index => $item)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 sm:p-6 shadow-sm flex flex-col lg:flex-row lg:items-center gap-4 hover:border-green-400 hover:shadow-md transition-all">
                        <div class="flex-1 flex items-start gap-3">
                            <span class="shrink-0 inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100 text-green-800 text-sm font-bold">{{ $index + 6 }}</span>
                            <span class="font-semibold text-gray-800 leading-relaxed pt-0.5">{{ $item }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2 lg:shrink-0 lg:w-auto mt-2 lg:mt-0">
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="f2_{{ $index+6 }}" value="1" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-5 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition-all select-none shadow-sm">
                                    متوفر
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="f2_{{ $index+6 }}" value="0" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-5 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500 transition-all select-none shadow-sm">
                                    غير متوفر
                                </div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- المحور الثالث: الاتجاه نحو التعلم بالمحمول --}}
                @php
                    $axis3 = [
                        "استخدام الهواتف المحمولة في التعلم أمر مشجع.",
                        "يساير التطبيق المقترح التطور العلمي والتكنولوجي في مجال التصميم على الأقمشة باستخدام الهواتف المحمولة.",
                    ];
                @endphp
                <div class="space-y-4">
                    <h3 class="bg-gray-100 p-4 rounded-xl font-bold text-green-800 border border-gray-200 shadow-sm text-lg">المحور الثالث: الاتجاه نحو التعلم بالمحمول</h3>
                    @foreach($axis3 as $index => $item)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 sm:p-6 shadow-sm flex flex-col lg:flex-row lg:items-center gap-4 hover:border-green-400 hover:shadow-md transition-all">
                        <div class="flex-1 flex items-start gap-3">
                            <span class="shrink-0 inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100 text-green-800 text-sm font-bold">{{ $index + 9 }}</span>
                            <span class="font-semibold text-gray-800 leading-relaxed pt-0.5">{{ $item }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2 lg:shrink-0 lg:w-auto mt-2 lg:mt-0">
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="f2_{{ $index+9 }}" value="1" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-5 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition-all select-none shadow-sm">
                                    متوفر
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="f2_{{ $index+9 }}" value="0" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-5 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500 transition-all select-none shadow-sm">
                                    غير متوفر
                                </div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- المحور الرابع: الصعوبات والاتجاهات الوجدانية --}}
                @php
                    $axis4 = [
                        "شعرت بملل أثناء أدائي للمهارات بواسطة التطبيق.",
                        "وجدت صعوبة في التعامل مع التطبيق المقترح.",
                        "أسلوب الدراسة شيق بالتطبيق المقترح.",
                    ];
                @endphp
                <div class="space-y-4">
                    <h3 class="bg-gray-100 p-4 rounded-xl font-bold text-green-800 border border-gray-200 shadow-sm text-lg">المحور الرابع: الصعوبات والاتجاهات الوجدانية</h3>
                    @foreach($axis4 as $index => $item)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 sm:p-6 shadow-sm flex flex-col lg:flex-row lg:items-center gap-4 hover:border-green-400 hover:shadow-md transition-all">
                        <div class="flex-1 flex items-start gap-3">
                            <span class="shrink-0 inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100 text-green-800 text-sm font-bold">{{ $index + 11 }}</span>
                            <span class="font-semibold text-gray-800 leading-relaxed pt-0.5">{{ $item }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2 lg:shrink-0 lg:w-auto mt-2 lg:mt-0">
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="f2_{{ $index+11 }}" value="1" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-5 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition-all select-none shadow-sm">
                                    متوفر
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1 sm:flex-none">
                                <input type="radio" required name="f2_{{ $index+11 }}" value="0" class="peer sr-only">
                                <div class="rounded-lg border border-gray-200 px-5 py-3 sm:py-2 text-center text-sm font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500 transition-all select-none shadow-sm">
                                    غير متوفر
                                </div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8 text-center">
                <button type="submit" style="background-color: #166534" class="text-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-green-800 transition-colors shadow-md">إرسال التقييم</button>
            </div>
        </form>
    </div>
</div>
@endsection
