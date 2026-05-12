@extends('admin.layouts.admin')

@section('title', 'المشاركون')
@section('page_title', 'المشاركون')

@section('content')
    <!-- Filter + Add -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.participants.index', ['filter' => 'all']) }}"
                   class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $filter === 'all' ? 'bg-primary-50 text-primary-600' : 'text-slate-500 hover:bg-slate-50' }}">
                    الكل
                </a>
                <a href="{{ route('admin.participants.index', ['filter' => 'completed']) }}"
                   class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $filter === 'completed' ? 'bg-emerald-50 text-emerald-600' : 'text-slate-500 hover:bg-slate-50' }}">
                    مكتمل
                </a>
                <a href="{{ route('admin.participants.index', ['filter' => 'not_completed']) }}"
                   class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $filter === 'not_completed' ? 'bg-amber-50 text-amber-600' : 'text-slate-500 hover:bg-slate-50' }}">
                    غير مكتمل
                </a>
            </div>

            <!-- Add Participant -->
            <form method="POST" action="{{ route('admin.participants.store') }}" class="flex items-center gap-2">
                @csrf
                <input type="text" name="name" placeholder="اسم المشارك..." required
                       class="rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none w-48">
                <button type="submit"
                        class="px-4 py-2 bg-primary-500 text-white rounded-lg text-sm font-medium hover:bg-primary-600 transition-colors flex items-center gap-1">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    إضافة
                </button>
            </form>
        </div>

        @if(session('generated_code'))
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3 mb-4 flex items-center gap-3">
                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600"></i>
                <span class="text-sm text-emerald-700">تم إنشاء المشارك بنجاح — الكود: <strong class="text-lg">{{ session('generated_code') }}</strong></span>
            </div>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-4 py-3 font-medium">الكود</th>
                        <th class="px-4 py-3 font-medium">الاسم</th>
                        <th class="px-4 py-3 font-medium">الحالة</th>
                        <th class="px-4 py-3 font-medium">بدأ في</th>
                        <th class="px-4 py-3 font-medium">أكمل في</th>
                        <th class="px-4 py-3 font-medium">إجراء</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($participants as $p)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-4 py-3 font-bold text-primary-600">{{ $p->code }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $p->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @if($p->status === 'completed')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> مكتمل
                                    </span>
                                @elseif($p->status === 'in_progress')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> قيد التنفيذ
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> معلّق
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-500">{{ $p->started_at?->format('Y-m-d H:i') ?? '—' }}</td>
                            <td class="px-4 py-3 text-xs text-slate-500">{{ $p->completed_at?->format('Y-m-d H:i') ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.participants.destroy', $p) }}"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المشارك؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400">لا يوجد مشاركون</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
