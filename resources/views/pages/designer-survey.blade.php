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

            <div class="space-y-4 mt-8">
                @php
                    $items = [
                        "وضوح أهداف التطبيق.",
                        "ساعدني التطبيق على التعلم بسهولة في أي وقت.",
                        "ساعدني التطبيق على التعلم بسهولة في أي مكان.",
                        "المادة العلمية للتطبيق المقترح منظمة بشكل منطقى.",
                        "يحتوي التطبيق على عدد كافي من الأشكال والصور التوضيحية.",
                        "يلبي التطبيق الاحتياجات الفعلية لدى المهتمين في التصميم على الاقمشة.",
                        "يسهم البرنامج في تحسين مستوى الأداء في التصميم على الاقمشة.",
                        "يعد التطبيق المقترح أحد الأساليب الحديثة لتعلم التصميم على الاقمشة.",
                        "استخدام الهواتف المحمولة في التعلم أمر مشجع.",
                        "يساير التطبيق المقترح التطور العلمي والتكنولوجي في مجال التصميم على الاقمشة باستخدام الهواتف المحمولة.",
                        "شعرت بملل أثناء أدائي للمهارات بواسطة التطبيق. (عبارة سلبية)",
                        "وجدت صعوبة في التعامل مع التطبيق المقترح. (عبارة سلبية)",
                        "أسلوب الدراسة شيق بالتطبيق المقترح."
                    ];
                @endphp
                
                @foreach($items as $index => $item)
                @php
                    $isNegative = str_contains($item, '(عبارة سلبية)');
                    $bgClass = $isNegative ? 'bg-red-50 hover:bg-red-100 hover:border-red-300' : 'bg-white hover:border-green-400';
                    $titleColor = $isNegative ? 'text-red-900' : 'text-gray-800';
                    $numBg = $isNegative ? 'bg-red-200 text-red-900' : 'bg-green-100 text-green-800';
                @endphp
                <div class="{{ $bgClass }} border border-gray-200 rounded-xl p-5 sm:p-6 shadow-sm flex flex-col xl:flex-row xl:items-center gap-4 hover:shadow-md transition-all">
                    <div class="flex-1 flex items-start gap-3">
                        <span class="shrink-0 inline-flex items-center justify-center w-7 h-7 rounded-full {{ $numBg }} text-sm font-bold">{{ $index + 1 }}</span>
                        <span class="font-semibold {{ $titleColor }} leading-relaxed pt-0.5">{{ $item }}</span>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 w-full xl:w-auto xl:shrink-0 mt-3 xl:mt-0">
                        <label class="cursor-pointer">
                            <input type="radio" required name="f2_{{ $index+1 }}" value="{{ $isNegative ? 1 : 5 }}" class="peer sr-only score-calc">
                            <div class="rounded-lg border border-gray-200 px-2 py-2 text-center text-xs font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition-all select-none shadow-sm h-full flex flex-col justify-center items-center gap-1">
                                <span>متوفر بشدة</span>
                                <span class="text-[11px] opacity-80">({{ $isNegative ? 1 : 5 }})</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" required name="f2_{{ $index+1 }}" value="{{ $isNegative ? 2 : 4 }}" class="peer sr-only score-calc">
                            <div class="rounded-lg border border-gray-200 px-2 py-2 text-center text-xs font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-green-500 peer-checked:text-white peer-checked:border-green-500 transition-all select-none shadow-sm h-full flex flex-col justify-center items-center gap-1">
                                <span>متوفر</span>
                                <span class="text-[11px] opacity-80">({{ $isNegative ? 2 : 4 }})</span>
                            </div>
                        </label>
                        <label class="cursor-pointer {{ $index == 12 ? 'col-span-2 sm:col-span-1' : '' }}">
                            <input type="radio" required name="f2_{{ $index+1 }}" value="3" class="peer sr-only score-calc">
                            <div class="rounded-lg border border-gray-200 px-2 py-2 text-center text-xs font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-yellow-500 peer-checked:text-white peer-checked:border-yellow-500 transition-all select-none shadow-sm h-full flex flex-col justify-center items-center gap-1">
                                <span>إلى حد ما</span>
                                <span class="text-[11px] opacity-80">(3)</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" required name="f2_{{ $index+1 }}" value="{{ $isNegative ? 4 : 2 }}" class="peer sr-only score-calc">
                            <div class="rounded-lg border border-gray-200 px-2 py-2 text-center text-xs font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-orange-500 peer-checked:text-white peer-checked:border-orange-500 transition-all select-none shadow-sm h-full flex flex-col justify-center items-center gap-1">
                                <span>غير متوفر</span>
                                <span class="text-[11px] opacity-80">({{ $isNegative ? 4 : 2 }})</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" required name="f2_{{ $index+1 }}" value="{{ $isNegative ? 5 : 1 }}" class="peer sr-only score-calc">
                            <div class="rounded-lg border border-gray-200 px-2 py-2 text-center text-xs font-bold text-gray-600 hover:bg-gray-50 peer-checked:bg-red-600 peer-checked:text-white peer-checked:border-red-600 transition-all select-none shadow-sm h-full flex flex-col justify-center items-center gap-1">
                                <span>غير متوفر بشدة</span>
                                <span class="text-[11px] opacity-80">({{ $isNegative ? 5 : 1 }})</span>
                            </div>
                        </label>
                    </div>
                </div>
                @endforeach
                
                <!-- صف المجموع الكلي -->
                <div class="bg-gray-100 font-bold text-green-800 border-2 border-green-600 rounded-xl p-4 sm:p-6 flex justify-between items-center mt-6">
                    <span class="text-lg">المجموع الكلي:</span>
                    <span class="text-2xl" id="total-score">- / 65</span>
                </div>
            </div>

            <div class="mt-4 text-sm text-red-600 font-bold bg-red-50 p-3 rounded-lg inline-block">
                * ملحوظة: العبارات (11) و (12) عبارات سلبية (يتم عكس درجتها برمجياً في المجموع).
            </div>

            <div class="mt-8 text-center">
                <button type="submit" style="background-color: #166534" class="text-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-green-800 transition-colors shadow-md">إرسال التقييم</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('.score-calc');
        const totalDisplay = document.getElementById('total-score');

        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                let total = 0;
                let answeredCount = 0;
                
                for(let i = 1; i <= 13; i++) {
                    const selected = document.querySelector(`input[name="f2_${i}"]:checked`);
                    if(selected) {
                        total += parseInt(selected.value);
                        answeredCount++;
                    }
                }

                if (answeredCount > 0) {
                    totalDisplay.innerText = `${total} / 65`;
                    totalDisplay.classList.add('text-green-800');
                }
            });
        });
    });
</script>
@endpush
@endsection
