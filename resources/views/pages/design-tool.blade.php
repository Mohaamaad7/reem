@php
    $isAr = session('lang', 'ar') === 'ar';
@endphp
@extends('layouts.app')

@section('title', $isAr ? 'أداة التصميم' : 'Design Tool')

@section('content')
<section class="dt-workspace">

    {{-- ═══════════════════════════════════════════
         DRAWING TOOLS — Left vertical toolbar
         ═══════════════════════════════════════════ --}}
    <div class="dt-draw-tools" id="dt-draw-tools">
        {{-- Mode Toggle --}}
        <button class="dt-draw-btn" id="dt-draw-mode" type="button"
                title="{{ $isAr ? 'وضع التحديد' : 'Selection Mode' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 3l7.07 16.97 2.51-7.39 7.39-2.51L3 3z"/>
            </svg>
        </button>

        <hr class="dt-draw-sep">

        {{-- Brushes --}}
        <button class="dt-draw-btn dt-brush-btn is-active" data-brush="pencil" type="button"
                title="{{ $isAr ? 'قلم رصاص' : 'Pencil' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.828 2.828 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
            </svg>
        </button>

        <button class="dt-draw-btn dt-brush-btn" data-brush="spray" type="button"
                title="{{ $isAr ? 'بخاخ' : 'Spray' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="2.5"/>
                <circle cx="4" cy="7" r="1.2"/>
                <circle cx="20" cy="7" r="1.2"/>
                <circle cx="7" cy="19" r="1.2"/>
                <circle cx="17" cy="19" r="1.2"/>
            </svg>
        </button>

        <button class="dt-draw-btn dt-brush-btn" data-brush="eraser" type="button"
                title="{{ $isAr ? 'ممحاة' : 'Eraser' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 20H7L3 16c-.8-.8-.8-2 0-2.8l10-10c.8-.8 2-.8 2.8 0l5 5c.8.8.8 2 0 2.8L12 17"/>
                <path d="M9 9l6 6"/>
            </svg>
        </button>
    </div>

    {{-- ═══════════════════════════════════════════
         DRAW SETTINGS — narrow panel between toolbar & canvas
         ═══════════════════════════════════════════ --}}
    <div class="dt-draw-settings" id="dt-draw-settings" hidden>
        {{-- Pencil / Spray size --}}
        <div class="dt-draw-setting-item" id="dt-draw-size-wrap" hidden>
            <label class="dt-draw-setting-label">{{ $isAr ? 'الحجم' : 'Size' }}</label>
            <div class="dt-draw-setting-row">
                <input type="range" id="dt-brush-size" class="dt-draw-slider"
                       min="1" max="50" value="5" step="1">
                <span class="dt-draw-setting-val" id="dt-brush-size-label">5</span>
            </div>
        </div>
        {{-- Pencil / Spray color --}}
        <div class="dt-draw-setting-item" id="dt-draw-color-wrap" hidden>
            <label class="dt-draw-setting-label">{{ $isAr ? 'اللون' : 'Color' }}</label>
            <div class="dt-draw-setting-row">
                <input type="color" id="dt-brush-color" class="dt-draw-color"
                       value="#000000">
            </div>
        </div>
        {{-- Eraser size --}}
        <div class="dt-draw-setting-item" id="dt-eraser-size-wrap" hidden>
            <label class="dt-draw-setting-label">{{ $isAr ? 'الممحاة' : 'Eraser' }}</label>
            <div class="dt-draw-setting-row">
                <input type="range" id="dt-eraser-size" class="dt-draw-slider"
                       min="5" max="80" value="20" step="1">
                <span class="dt-draw-setting-val" id="dt-eraser-size-label">20</span>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         CANVAS AREA — Left / Top on mobile
         ═══════════════════════════════════════════ --}}
    <div class="dt-canvas-area">

        {{-- Workspace Tabs --}}
        <div class="dt-workspace-tabs" id="dt-workspace-tabs">
            {{-- Populated by JS --}}
        </div>

        <div class="dt-canvas-frame">
            <canvas
                id="design-canvas"
                width="400"
                height="533"
            ></canvas>
            <div class="dt-empty-state" id="dt-empty-state">
                <span class="dt-empty-state__icon" aria-hidden="true">🎨</span>
                <span>{{ $isAr ? 'اختاري قماشاً ونقشة لتبدئي الإبداع' : 'Select a fabric and pattern to start' }}</span>
            </div>
        </div>

        {{-- Floating Action Bar --}}
        <div class="dt-floating-actions">
            <div class="dt-floating-actions__bar">
                <button class="dt-fab-btn dt-fab-btn--icon" id="dt-undo-btn" type="button" disabled
                        title="{{ $isAr ? 'تراجع (Ctrl+Z)' : 'Undo (Ctrl+Z)' }}">
                    ↩
                </button>
                <button class="dt-fab-btn dt-fab-btn--icon" id="dt-redo-btn" type="button" disabled
                        title="{{ $isAr ? 'إعادة (Ctrl+Shift+Z)' : 'Redo (Ctrl+Shift+Z)' }}">
                    ↪
                </button>
                <button class="dt-fab-btn dt-fab-btn--danger" id="dt-delete-btn" type="button" disabled>
                    🗑️ {{ $isAr ? 'حذف' : 'Delete' }}
                </button>
                <button class="dt-fab-btn dt-fab-btn--primary dt-save-btn" type="button" disabled>
                    ✓ {{ $isAr ? 'حفظ التصميم' : 'Save Design' }}
                </button>
                <a href="{{ route('survey') }}" class="dt-fab-btn dt-fab-btn--success dt-proceed-btn" style="display:none;">
                    {{ $isAr ? 'الانتقال للاستبيان' : 'Proceed to Survey' }}
                </a>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════
         SIDEBAR — Right / Bottom on mobile
         ═══════════════════════════════════════════ --}}
    <aside class="dt-sidebar">

        {{-- Tab Navigation --}}
        <div class="dt-tabs" role="tablist">
            <button class="dt-tab-btn dt-tab-btn--active" data-tab="dt-tab-fabric" role="tab" type="button">
                <span class="dt-tab-btn__icon" aria-hidden="true">🧵</span>
                <span>{{ $isAr ? 'القماش' : 'Fabric' }}</span>
            </button>
            <button class="dt-tab-btn" data-tab="dt-tab-pattern" role="tab" type="button">
                <span class="dt-tab-btn__icon" aria-hidden="true">🎨</span>
                <span>{{ $isAr ? 'النقوش' : 'Patterns' }}</span>
            </button>
            <button class="dt-tab-btn" data-tab="dt-tab-adjust" role="tab" type="button">
                <span class="dt-tab-btn__icon" aria-hidden="true">◐</span>
                <span>{{ $isAr ? 'التعديل' : 'Adjust' }}</span>
            </button>
        </div>

        {{-- Tab Panels --}}
        <div class="dt-tab-panels">

            {{-- Tab 1: Fabric --}}
            <div class="dt-tab-panel dt-tab-panel--active" id="dt-tab-fabric" role="tabpanel">
                <h2 class="dt-panel-title">{{ $isAr ? 'خامة القماش' : 'Fabric' }}</h2>
                <p class="dt-panel-desc">{{ $isAr ? 'اختاري الخامة الأساسية التي ستشكّل خلفية تصميمك.' : 'Select the base fabric for your design.' }}</p>
                <div class="dt-grid dt-grid--2col" id="dt-fabric-grid">
                    {{-- Populated by JS --}}
                </div>
            </div>

            {{-- Tab 2: Patterns --}}
            <div class="dt-tab-panel" id="dt-tab-pattern" role="tabpanel">
                <h2 class="dt-panel-title">{{ $isAr ? 'زخارف ونقوش' : 'Patterns' }}</h2>
                <p class="dt-panel-desc">{{ $isAr ? 'اضغطي على النقشة لإضافتها، يمكنكِ إضافة عدة نسخ وتحريكها بحرية.' : 'Tap a pattern to add it. Add multiple copies and move them freely.' }}</p>
                <div class="dt-category-tabs" id="dt-category-tabs">
                    {{-- Populated by JS --}}
                </div>
                <div class="dt-grid dt-grid--3col" id="dt-pattern-grid">
                    {{-- Populated by JS --}}
                </div>
                <div class="dt-load-more-wrap" id="dt-load-more-wrap">
                    <button class="dt-load-more-btn" id="dt-load-more-btn" type="button" hidden>
                        {{ $isAr ? 'عرض المزيد' : 'Load More' }}
                    </button>
                </div>
            </div>

            {{-- Tab 3: Adjust --}}
            <div class="dt-tab-panel" id="dt-tab-adjust" role="tabpanel">
                <h2 class="dt-panel-title">{{ $isAr ? 'ضبط التصميم' : 'Adjustments' }}</h2>
                <p class="dt-panel-desc">{{ $isAr ? 'حدّدي عنصراً على القماش لتعديل خصائصه.' : 'Select an element on the canvas to adjust its properties.' }}</p>

                {{-- Opacity --}}
                <div class="dt-control-group">
                    <label class="dt-control-label" for="dt-opacity-slider">
                        {{ $isAr ? 'شفافية العنصر المحدد' : 'Element Opacity' }}
                    </label>
                    <div class="dt-slider-wrap">
                        <input
                            class="dt-slider__input"
                            id="dt-opacity-slider"
                            type="range"
                            min="30"
                            max="100"
                            value="80"
                            step="1"
                            aria-label="{{ $isAr ? 'الشفافية' : 'Opacity' }}"
                        >
                        <span class="dt-opacity-label" id="dt-opacity-label">80%</span>
                    </div>
                </div>

                {{-- Blend Modes (raster PNG/WebP) --}}
                <div class="dt-control-group" id="dt-blend-section">
                    <label class="dt-control-label">{{ $isAr ? 'طريقة الدمج' : 'Blend Mode' }}</label>
                    <p class="dt-panel-desc" style="margin-bottom:0.75rem;">{{ $isAr ? 'اختاري كيفية دمج التصميم مع القماش' : 'Choose how the pattern blends with the fabric.' }}</p>
                    <div class="dt-blend-group" id="dt-blend-group">
                        {{-- Populated by JS --}}
                    </div>
                </div>

                {{-- Color Picker (SVG) --}}
                <div class="dt-control-group" id="dt-color-section" style="display:none;">
                    <label class="dt-control-label">{{ $isAr ? 'لون النقشة' : 'Pattern Color' }}</label>
                    <p class="dt-panel-desc" style="margin-bottom:0.75rem;">{{ $isAr ? 'اضغطي على جزء من التصميم ثم اختاري لوناً' : 'Click a part of the design, then pick a color.' }}</p>
                    <div class="dt-color-swatches" id="dt-color-swatches">
                        {{-- Populated by JS --}}
                    </div>
                    <div class="dt-color-custom">
                        <label class="dt-color-custom__label" for="dt-color-picker">
                            {{ $isAr ? 'لون مخصص' : 'Custom color' }}
                        </label>
                        <input type="color" id="dt-color-picker" class="dt-color-custom__input" value="#2E5B1E">
                    </div>
                </div>

            </div>

        </div>{{-- /.dt-tab-panels --}}

        {{-- Saved Designs Gallery (shown after first save) --}}
        <div class="dt-saved-gallery" id="dt-saved-gallery" hidden>
            <div class="dt-saved-gallery__header">
                <h3 class="dt-saved-gallery__title">{{ $isAr ? 'تصاميمك المحفوظة' : 'Saved Designs' }}</h3>
            </div>
            <div class="dt-grid dt-grid--3col" id="dt-saved-grid">
                {{-- Populated by JS --}}
            </div>
        </div>

    </aside>

</section>

<script>
(function() {
    var tabs = document.querySelectorAll('.dt-tab-btn');
    tabs.forEach(function(btn) {
        btn.addEventListener('click', function() {
            tabs.forEach(function(b) { b.classList.remove('dt-tab-btn--active'); });
            document.querySelectorAll('.dt-tab-panel').forEach(function(p) { p.classList.remove('dt-tab-panel--active'); });
            btn.classList.add('dt-tab-btn--active');
            var panel = document.getElementById(btn.dataset.tab);
            if (panel) panel.classList.add('dt-tab-panel--active');
        });
    });
})();
</script>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
<script src="{{ asset('js/fabric-eraser.js') }}"></script>
<script src="{{ asset('js/canvas-tool.js') }}" defer></script>
@endpush
