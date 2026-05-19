@extends('admin.layouts.admin')

@section('title', 'نتائج تحكيم المصممين')
@section('page_title', 'نتائج استمارة تحكيم المصممين (ملحق 11)')

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
                        <th class="p-3">اسم المصمم</th>
                        <th class="p-3">المصنع</th>
                        <th class="p-3">التاريخ</th>
                        <th class="p-3">إجمالي الدرجات</th>
                        <th class="p-3">التفاصيل</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluations as $eval)
                        @php
                            $total = 0; 
                            for($i=1; $i<=13; $i++) {
                                $total += $eval->{"f2_$i"};
                            }
                        @endphp
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $eval->id }}</td>
                            <td class="p-3 font-semibold">{{ $eval->designer_name ?: 'غير محدد' }}</td>
                            <td class="p-3">{{ $eval->factory_name ?: 'غير محدد' }}</td>
                            <td class="p-3">{{ $eval->created_at->format('Y-m-d H:i') }}</td>
                            <td class="p-3 font-bold text-green-700">{{ $total }} / 65</td>
                            <td class="p-3 text-sm text-gray-600">
                                <!-- Could add a modal or details view here later -->
                                <button class="text-blue-600 hover:underline" onclick="alert('تفاصيل قريباً')">عرض التفاصيل</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
