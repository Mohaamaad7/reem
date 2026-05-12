@extends('admin.layouts.admin')

@section('title', 'التصاميم المحفوظة')
@section('page_title', 'التصاميم المحفوظة')

@section('content')
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-slate-800">جميع التصاميم ({{ $designs->total() }})</h2>
        </div>

        @if($designs->isEmpty())
            <div class="text-center py-16 text-slate-400">
                <i data-lucide="image-off" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                <p class="text-sm">لا توجد تصاميم محفوظة بعد</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
                @foreach($designs as $design)
                    <div class="bg-slate-50 rounded-xl overflow-hidden border border-slate-100 hover:shadow-md transition-shadow">
                        <div class="aspect-square bg-slate-100">
                            @if($design->preview_image)
                                <img src="{{ $design->preview_image }}" alt="Design"
                                     class="w-full h-full object-cover" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i data-lucide="image" class="w-8 h-8"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-2.5 space-y-1">
                            <p class="text-xs font-medium text-slate-700">
                                {{ $design->participant->code ?? '—' }}
                            </p>
                            <p class="text-xs text-slate-400">{{ $design->fabric_id ?? '—' }}</p>
                            <p class="text-xs text-slate-400">{{ $design->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $designs->links() }}
            </div>
        @endif
    </div>
@endsection
