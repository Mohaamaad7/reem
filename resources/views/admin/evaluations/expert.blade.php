@extends('admin.layouts.admin')

@section('title', 'نتائج تحكيم المتخصصين')
@section('page_title', 'نتائج استمارة تحكيم المتخصصين (ملحق 9 و 10)')

@section('content')
<div class="card p-6">

    @if($evaluations->isEmpty())
        <div class="text-center py-8 text-gray-500">
            لا توجد تقييمات حتى الآن.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="p-3">#</th>
                        <th class="p-3">الاسم</th>
                        <th class="p-3">التاريخ</th>
                        <th class="p-3">القسم الأول</th>
                        <th class="p-3">القسم الثاني</th>
                        <th class="p-3">القسم الثالث</th>
                        <th class="p-3">القسم الرابع</th>
                        <th class="p-3">الملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluations as $eval)
                        @php
                            $q1 = 0; for($i=1; $i<=8; $i++) $q1 += $eval->{"q1_$i"};
                            $q2 = 0; for($i=9; $i<=14; $i++) $q2 += $eval->{"q2_$i"};
                            $q3 = 0; for($i=15; $i<=17; $i++) $q3 += $eval->{"q3_$i"};
                            $q4 = 0; for($i=18; $i<=27; $i++) $q4 += $eval->{"q4_$i"};
                        @endphp
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $eval->id }}</td>
                            <td class="p-3 font-semibold">{{ $eval->evaluator_name ?: 'غير محدد' }}</td>
                            <td class="p-3">{{ $eval->created_at->format('Y-m-d H:i') }}</td>
                            <td class="p-3">{{ $q1 }} / 24</td>
                            <td class="p-3">{{ $q2 }} / 18</td>
                            <td class="p-3">{{ $q3 }} / 9</td>
                            <td class="p-3">{{ $q4 }} / 30</td>
                            <td class="p-3 text-sm text-gray-600 max-w-xs truncate" title="{{ $eval->notes }}">
                                {{ $eval->notes ?: '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
