@extends('admin.layouts.admin')

@section('title', 'ردود الاستبيان')
@section('page_title', 'ردود الاستبيان')

@section('content')
    <!-- Export -->
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.responses.export') }}"
           class="flex items-center gap-2 px-4 py-2 bg-secondary-500 text-white rounded-xl text-sm font-medium hover:bg-secondary-600 transition-colors">
            <i data-lucide="download" class="w-4 h-4"></i>
            تصدير CSV
        </a>
    </div>

    <!-- Averages -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 mb-6">
        @foreach([
            'tool_ease' => 'سهولة الأداة',
            'tool_visual' => 'جودة المعاينة',
            'morris_before' => 'موريس (قبل)',
            'morris_after' => 'موريس (بعد)',
            'technique' => 'النقشة الزائدة',
            'eco_awareness' => 'الوعي البيئي',
            'overall' => 'التقييم العام',
        ] as $key => $label)
            <div class="bg-white rounded-xl border border-slate-100 p-3 text-center">
                <p class="text-xs text-slate-400 mb-1">{{ $label }}</p>
                <p class="text-lg font-bold text-slate-800">{{ $averages[$key] ?? '—' }}<span class="text-xs text-slate-400">/5</span></p>
            </div>
        @endforeach
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-4 py-3 font-medium">#</th>
                        <th class="px-4 py-3 font-medium">المشارك</th>
                        <th class="px-4 py-3 font-medium">التقييم العام</th>
                        <th class="px-4 py-3 font-medium">التوصية</th>
                        <th class="px-4 py-3 font-medium">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($responses as $r)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-4 py-3 text-slate-400">{{ $r->id }}</td>
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $r->participant_code }} — {{ $r->participant_name }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-xs font-medium">
                                    {{ $r->app_overall_rating ?? '—' }}/5
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $r->would_recommend ?? '—' }}/5</td>
                            <td class="px-4 py-3 text-xs text-slate-400">{{ $r->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-400">لا توجد ردود بعد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
