@extends('admin.layouts.admin')

@section('title', 'لوحة التحكم')
@section('page_title', 'لوحة التحكم')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- المشاركون -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 text-sm font-medium">عدد المشاركين</h3>
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800">{{ number_format($stats['participants']) }}</span>
            </div>
        </div>

        <!-- التصاميم المحفوظة -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 text-sm font-medium">التصاميم المحفوظة</h3>
                <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                    <i data-lucide="image" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800">{{ number_format($stats['designs']) }}</span>
            </div>
        </div>

        <!-- ردود الاستبيان -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 text-sm font-medium">ردود الاستبيان</h3>
                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800">{{ number_format($stats['responses']) }}</span>
            </div>
        </div>

        <!-- النقشات المرفوعة -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 text-sm font-medium">النقشات المرفوعة</h3>
                <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
                    <i data-lucide="grid-2x2" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800">{{ number_format($stats['patterns']) }}</span>
            </div>
        </div>
    </div>

    <!-- Recent Saved Designs Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800">آخر التصاميم المحفوظة</h2>
            <a href="{{ route('admin.designs.index') }}" class="text-sm font-medium text-primary-500 hover:text-primary-600">عرض الكل</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-medium">كود المشارك</th>
                        <th class="px-6 py-4 font-medium">القماش</th>
                        <th class="px-6 py-4 font-medium">النقشات المستخدمة</th>
                        <th class="px-6 py-4 font-medium">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($recentDesigns as $design)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-700">
                                {{ $design->participant->code ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $design->fabric_id ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                @if($design->patterns_used)
                                    {{ is_array($design->patterns_used) ? implode(', ', $design->patterns_used) : $design->patterns_used }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-xs">
                                {{ $design->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                لا توجد تصاميم محفوظة بعد
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
