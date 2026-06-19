@extends('admin.layouts.admin')

@section('title', 'نتائج تحكيم المصممين')
@section('page_title', 'نتائج استمارة تحكيم المصممين (ملحق 11)')

@section('content')
<div class="card p-6">

    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <div class="text-sm text-slate-500">
            إجمالي التقييمات: <span class="font-bold text-slate-800">{{ $evaluations->count() }}</span>
        </div>
        @if($evaluations->isNotEmpty())
        <a href="{{ route('admin.evaluations.designer.export') }}"
           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors shadow-sm">
            <i data-lucide="download" class="w-4 h-4"></i>
            تصدير Excel (CSV)
        </a>
        @endif
    </div>

    @if($evaluations->isEmpty())
        <div class="text-center py-8 text-gray-500">
            لا توجد تقييمات حتى الآن.
        </div>
    @else
        @php
            $questionLabels = [
                1 => 'وضوح أهداف التطبيق',
                2 => 'التعلم بسهولة في أي وقت',
                3 => 'التعلم بسهولة في أي مكان',
                4 => 'المادة العلمية منظمة',
                5 => 'أشكال وصور كافية',
                6 => 'يلبي الاحتياجات الفعلية',
                7 => 'تحسين مستوى الأداء',
                8 => 'أسلوب حديث للتعلم',
                9 => 'التعلم بالمحمول مشجع',
                10 => 'يساير التطور التكنولوجي',
                11 => 'شعرت بملل',
                12 => 'وجدت صعوبة',
                13 => 'أسلوب شيق',
            ];
        @endphp
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="p-3 sticky right-0 bg-gray-50 z-10">#</th>
                        <th class="p-3 whitespace-nowrap">اسم المصمم</th>
                        <th class="p-3 whitespace-nowrap">المصنع</th>
                        <th class="p-3 whitespace-nowrap">التاريخ</th>
                        @for($i = 1; $i <= 13; $i++)
                        <th class="p-2 whitespace-nowrap text-xs" title="{{ $questionLabels[$i] }}">س{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluations as $eval)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 sticky right-0 bg-white z-10">{{ $eval->id }}</td>
                            <td class="p-3 font-semibold whitespace-nowrap">{{ $eval->designer_name ?: 'غير محدد' }}</td>
                            <td class="p-3 whitespace-nowrap">{{ $eval->factory_name ?: 'غير محدد' }}</td>
                            <td class="p-3 whitespace-nowrap">{{ $eval->created_at->format('Y-m-d H:i') }}</td>
                            @for($i = 1; $i <= 13; $i++)
                                @php $val = $eval->{"f2_$i"}; @endphp
                                <td class="p-2 text-center">
                                    @if($val == 1)
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold" title="متوفر">✓</span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-100 text-red-600 text-xs font-bold" title="غير متوفر">✗</span>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- مفتاح الأسئلة --}}
        <div class="mt-6 p-4 bg-slate-50 rounded-lg border border-slate-200">
            <h4 class="font-bold text-slate-700 mb-3 text-sm">مفتاح الأسئلة:</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 text-xs text-slate-600">
                @for($i = 1; $i <= 13; $i++)
                <div><span class="font-bold text-slate-800">س{{ $i }}:</span> {{ $questionLabels[$i] }}</div>
                @endfor
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>lucide.createIcons();</script>
@endpush
@endsection
