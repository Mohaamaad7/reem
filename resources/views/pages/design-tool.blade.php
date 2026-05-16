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
        <button class="dt-draw-btn is-active" id="dt-draw-mode" type="button"
                title="{{ $isAr ? 'وضع التحديد' : 'Selection Mode' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 3l7.07 16.97 2.51-7.39 7.39-2.51L3 3z"/>
            </svg>
        </button>

        <hr class="dt-draw-sep">

        <button class="dt-draw-btn dt-brush-btn" data-brush="pencil" type="button"
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
         CANVAS AREA
         ═══════════════════════════════════════════ --}}
    <div class="dt-canvas-area">

        {{-- Workspace Tabs --}}
        <div class="dt-workspace-tabs" id="dt-workspace-tabs"></div>

        <div class="dt-canvas-frame">
            {{-- Floating Toolbar (above canvas) --}}
            <div class="dt-floating-toolbar" id="dt-floating-toolbar" hidden>
                <div class="dt-ftb-colors" id="dt-ftb-colors">
                    <button class="dt-ftb-color is-active" data-color="#2E5B1E" style="background:#2E5B1E" title="{{ $isAr ? 'أخضر' : 'Green' }}"></button>
                    <button class="dt-ftb-color" data-color="#8B1A1A" style="background:#8B1A1A" title="{{ $isAr ? 'أحمر' : 'Red' }}"></button>
                    <button class="dt-ftb-color" data-color="#D4AF37" style="background:#D4AF37" title="{{ $isAr ? 'ذهبي' : 'Gold' }}"></button>
                </div>
                <div class="dt-ftb-sep"></div>
                <button class="dt-ftb-brush-btn is-active" id="dt-ftb-brush" type="button" title="{{ $isAr ? 'فرشاة' : 'Brush' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 3a2.828 2.828 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </button>
                <div class="dt-ftb-size-wrap">
                    <span class="dt-ftb-size-label" id="dt-ftb-size-label">5px</span>
                    <input type="range" class="dt-ftb-size-slider" id="dt-ftb-size-slider" min="1" max="50" value="5" step="1">
                </div>
            </div>

            <canvas id="design-canvas" width="400" height="533"></canvas>
            <div class="dt-empty-state" id="dt-empty-state">
                <span class="dt-empty-state__icon" aria-hidden="true">🎨</span>
                <span>{{ $isAr ? 'اضغطي "إضافة طبقة" للبدء' : 'Click "Add Layer" to start' }}</span>
            </div>
        </div>

        {{-- Floating Action Bar --}}
        <div class="dt-floating-actions">
            <div class="dt-floating-actions__bar">
                <button class="dt-fab-btn dt-fab-btn--icon" id="dt-undo-btn" type="button" disabled
                        title="{{ $isAr ? 'تراجع (Ctrl+Z)' : 'Undo (Ctrl+Z)' }}">↩</button>
                <button class="dt-fab-btn dt-fab-btn--icon" id="dt-redo-btn" type="button" disabled
                        title="{{ $isAr ? 'إعادة (Ctrl+Shift+Z)' : 'Redo (Ctrl+Shift+Z)' }}">↪</button>
                <button class="dt-fab-btn dt-fab-btn--primary dt-save-btn" type="button" disabled>
                    ✓ {{ $isAr ? 'حفظ' : 'Save' }}
                </button>
                <a href="{{ route('survey') }}" class="dt-fab-btn dt-fab-btn--success dt-proceed-btn" style="display:none;">
                    {{ $isAr ? 'الاستبيان' : 'Survey' }}
                </a>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════
         LAYERS PANEL — Right sidebar
         ═══════════════════════════════════════════ --}}
    <aside class="dt-sidebar-right" id="dt-sidebar-right">
        <div class="dt-sidebar-right__header">
            <h3 class="dt-sidebar-right__title">{{ $isAr ? 'الطبقات' : 'Layers' }}</h3>
        </div>
        <div class="dt-sidebar-right__body">
            <div style="position:relative;">
                <button class="dt-add-layer-btn" id="dt-add-layer-btn" type="button">
                    <span>＋</span>
                    <span>{{ $isAr ? 'إضافة طبقة' : 'Add Layer' }}</span>
                </button>
                <div class="dt-layer-type-dropdown" id="dt-layer-type-dropdown" hidden>
                    <button class="dt-layer-type-option" data-type="fabric">
                        <span class="dt-layer-type-option__icon">🧵</span>
                        <span>{{ $isAr ? 'طبقة قماش' : 'Fabric Layer' }}</span>
                    </button>
                    <button class="dt-layer-type-option" data-type="pattern">
                        <span class="dt-layer-type-option__icon">🎨</span>
                        <span>{{ $isAr ? 'طبقة نقشة' : 'Pattern Layer' }}</span>
                    </button>
                    <button class="dt-layer-type-option" data-type="drawing">
                        <span class="dt-layer-type-option__icon">✏️</span>
                        <span>{{ $isAr ? 'طبقة رسم حر' : 'Freehand Layer' }}</span>
                    </button>
                </div>
            </div>
            <div id="dt-layers-list"></div>
        </div>
    </aside>

    {{-- Keep old sidebar for mobile only --}}
    <aside class="dt-sidebar" id="dt-sidebar-mobile">
        <div class="dt-tabs" role="tablist">
            <button class="dt-tab-btn dt-tab-btn--active" data-tab="dt-tab-fabric" role="tab" type="button">
                <span class="dt-tab-btn__icon">🧵</span>
                <span>{{ $isAr ? 'القماش' : 'Fabric' }}</span>
            </button>
            <button class="dt-tab-btn" data-tab="dt-tab-pattern" role="tab" type="button">
                <span class="dt-tab-btn__icon">🎨</span>
                <span>{{ $isAr ? 'النقوش' : 'Patterns' }}</span>
            </button>
            <button class="dt-tab-btn" data-tab="dt-tab-adjust" role="tab" type="button">
                <span class="dt-tab-btn__icon">◐</span>
                <span>{{ $isAr ? 'التعديل' : 'Adjust' }}</span>
            </button>
        </div>
        <div class="dt-tab-panels">
            <div class="dt-tab-panel dt-tab-panel--active" id="dt-tab-fabric" role="tabpanel">
                <h2 class="dt-panel-title">{{ $isAr ? 'خامة القماش' : 'Fabric' }}</h2>
                <div class="dt-grid dt-grid--2col" id="dt-fabric-grid-mobile"></div>
            </div>
            <div class="dt-tab-panel" id="dt-tab-pattern" role="tabpanel">
                <h2 class="dt-panel-title">{{ $isAr ? 'زخارف ونقوش' : 'Patterns' }}</h2>
                <div class="dt-grid dt-grid--3col" id="dt-pattern-grid-mobile"></div>
            </div>
            <div class="dt-tab-panel" id="dt-tab-adjust" role="tabpanel">
                <h2 class="dt-panel-title">{{ $isAr ? 'ضبط التصميم' : 'Adjustments' }}</h2>
                <div class="dt-control-group">
                    <label class="dt-control-label">{{ $isAr ? 'شفافية' : 'Opacity' }}</label>
                    <div class="dt-slider-wrap">
                        <input class="dt-slider__input" id="dt-opacity-slider-mobile" type="range" min="30" max="100" value="80" step="1">
                        <span class="dt-opacity-label" id="dt-opacity-label-mobile">80%</span>
                    </div>
                </div>
            </div>
        </div>
    </aside>

</section>

{{-- ═══════════════════════════════════════════
     FABRIC MODAL
     ═══════════════════════════════════════════ --}}
<div class="dt-modal-overlay" id="dt-fabric-modal">
    <div class="dt-modal-content">
        <div class="dt-modal-header">
            <h3 class="dt-modal-title">{{ $isAr ? 'اختاري القماش' : 'Select Fabric' }}</h3>
            <button class="dt-modal-close" type="button">&times;</button>
        </div>
        <div class="dt-modal-body">
            <div class="dt-modal-grid" id="dt-fabric-modal-grid"></div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════
     PATTERN MODAL
     ═══════════════════════════════════════════ --}}
<div class="dt-modal-overlay" id="dt-pattern-modal">
    <div class="dt-modal-content">
        <div class="dt-modal-header">
            <h3 class="dt-modal-title">{{ $isAr ? 'اختاري النقشة' : 'Select Pattern' }}</h3>
            <button class="dt-modal-close" type="button">&times;</button>
        </div>
        <div class="dt-modal-body">
            <div class="dt-modal-grid" id="dt-pattern-modal-grid"></div>
        </div>
    </div>
</div>

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
