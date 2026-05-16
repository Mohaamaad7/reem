/**
 * Rawnaq — Design Tool Canvas Engine (Fabric.js 5.3.0)
 * =========================================================
 * Phase 4 Layout Fix — Complete rewrite
 *
 * Parts implemented:
 *  1. Responsive layout (CSS grid desktop/tablet, flex column mobile)
 *  2. Canvas square + responsive size calculation
 *  3. Deselect when clicking outside canvas
 *  4. Remove near-white borders from pattern images
 *  5. Canvas empty placeholder
 *  6. Subtle selection handles styling
 *  +  Mobile bottom sheet modals
 */

/* ── Asset Catalog (populated at runtime) ──────────────────── */
const AssetCatalog = {
    fabrics:  [],
    patterns: [],
};

/* ── Blend Mode Definitions ────────────────────────────────── */
/* ── Canvas aspect ratio (3:4 portrait, like a t-shirt) ──── */
const CANVAS_RATIO = 4 / 3;

const BLEND_MODES = [
    { id: 'multiply',   labelAr: 'متنسج',  labelEn: 'Woven',   op: 'multiply'   },
    { id: 'overlay',    labelAr: 'حيوي',   labelEn: 'Vivid',   op: 'overlay'    },
    { id: 'soft-light', labelAr: 'ناعم',   labelEn: 'Soft',    op: 'soft-light' },
    { id: 'screen',     labelAr: 'شفاف',   labelEn: 'Screen',  op: 'screen'     },
];

/* ── Auto-Save & Workspace Constants ────────────────────────── */
const AUTOSAVE_KEY = 'rawnaq_autosave';
const AUTOSAVE_DEBOUNCE = 500;
const WORKSPACES_KEY = 'rawnaq_workspaces';
const MAX_WORKSPACES = 10;

/* ── Helper: darken a hex color ────────────────────────────── */
function _darken(hex, amount) {
    const n = parseInt(hex.replace('#', ''), 16);
    const r = Math.max(0, (n >> 16) - amount);
    const g = Math.max(0, ((n >> 8) & 0xff) - amount);
    const b = Math.max(0, (n & 0xff) - amount);
    return '#' + ((1 << 24) | (r << 16) | (g << 8) | b).toString(16).slice(1);
}

/* ── Fabric SVG placeholder ── */
function _fabricSvgUrl(color) {
    const c = color || '#e8dcc8';
    const svg = '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400">' +
        '<rect width="400" height="400" fill="' + c + '"/>' +
        '<g stroke="' + _darken(c, 15) + '" stroke-width="0.6" opacity="0.5">' +
        Array.from({ length: 80 }, function(_, i) { return '<line x1="0" y1="' + (i * 5) + '" x2="400" y2="' + (i * 5) + '"/>'; }).join('') +
        Array.from({ length: 80 }, function(_, i) { return '<line x1="' + (i * 5) + '" y1="0" x2="' + (i * 5) + '" y2="400"/>'; }).join('') +
        '</g></svg>';
    return 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svg);
}

/* ═══════════════════════════════════════════════════════════════
   PART 4 — Remove Near-White Background
   ═══════════════════════════════════════════════════════════════ */
function removeNearWhiteBackground(imageUrl, callback) {
    var img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = function() {
        try {
            var offscreen = document.createElement('canvas');
            offscreen.width = img.naturalWidth || img.width;
            offscreen.height = img.naturalHeight || img.height;
            var ctx = offscreen.getContext('2d');
            ctx.drawImage(img, 0, 0);

            var imageData = ctx.getImageData(0, 0, offscreen.width, offscreen.height);
            var data = imageData.data;

            for (var i = 0; i < data.length; i += 4) {
                var r = data[i];
                var g = data[i + 1];
                var b = data[i + 2];
                if (r > 220 && g > 220 && b > 220) {
                    data[i + 3] = 0;
                }
            }

            ctx.putImageData(imageData, 0, 0);
            callback(offscreen.toDataURL());
        } catch (e) {
            console.warn('removeNearWhiteBackground failed, using original URL:', e);
            callback(imageUrl);
        }
    };
    img.onerror = function() {
        console.warn('removeNearWhiteBackground image load failed, using original URL');
        callback(imageUrl);
    };
    img.src = imageUrl;
}

/* ═══════════════════════════════════════════════════════════════
   Design Engine
   ═══════════════════════════════════════════════════════════════ */
class DesignEngine {

    constructor() {
        this.isAr = document.documentElement.lang === 'ar';

        /* ── Fabric.js canvas with subtle selection styles (Part 6) ── */
        this.canvas = new fabric.Canvas('design-canvas', {
            width: 400,
            height: Math.round(400 * CANVAS_RATIO),
            enableRetinaScaling: false,
            selectionColor: 'rgba(212, 175, 55, 0.15)',
            selectionBorderColor: 'rgba(212, 175, 55, 0.6)',
            selectionLineWidth: 1,
        });

        /* ── Guide frame reference (set in _drawGuideFrame) ── */
        this._guideFrame = null;

        /* ── Part 2: Initialize responsive dimensions (3:4) ── */
        this._resizeCanvas();
        window.addEventListener('resize', this._resizeCanvas.bind(this));

        /* ── Part 3: Deselect when clicking outside canvas ── */
        var self = this;
        document.addEventListener('click', function(e) {
            var wrapper = self.canvas.wrapperEl;
            if (wrapper && !wrapper.contains(e.target)) {
                var isColorTool = e.target.closest &&
                    (e.target.closest('.dt-color-section') ||
                     e.target.closest('.dt-color-custom') ||
                     e.target.closest('.dt-color-swatches'));
                if (isColorTool) return;
                self.canvas.discardActiveObject();
                self.canvas.requestRenderAll();
            }
        });

        /* ── DOM refs ── */
        this.emptyState  = document.getElementById('dt-empty-state');
        this.fabricGrid  = document.getElementById('dt-fabric-grid');
        this.patternGrid = document.getElementById('dt-pattern-grid');
        this.categoryTabs = document.getElementById('dt-category-tabs');
        this.blendGroup  = document.getElementById('dt-blend-group');
        this.opacitySlider = document.getElementById('dt-opacity-slider');
        this.opacityLabel  = document.getElementById('dt-opacity-label');
        this.deleteBtn   = document.getElementById('dt-delete-btn');
        this.saveBtns    = document.querySelectorAll('.dt-save-btn');
        this.proceedBtns = document.querySelectorAll('.dt-proceed-btn');
        this.savedGallery = document.getElementById('dt-saved-gallery');
        this.savedGrid   = document.getElementById('dt-saved-grid');

        /* ── Mobile DOM refs ── */
        this.fabricGridMobile  = document.getElementById('dt-fabric-grid-mobile');
        this.patternGridMobile = document.getElementById('dt-pattern-grid-mobile');
        this.categoryTabsMobile = document.getElementById('dt-category-tabs-mobile');
        this.loadMoreBtn   = document.getElementById('dt-load-more-btn');
        this.loadMoreBtnMobile = document.getElementById('dt-load-more-btn-mobile');
        this.blendGroupMobile  = document.getElementById('dt-blend-group-mobile');
        this.opacitySliderMobile = document.getElementById('dt-opacity-slider-mobile');
        this.opacityLabelMobile  = document.getElementById('dt-opacity-label-mobile');

        /* ── Color picker DOM refs (Step 3 smart toggle) ── */
        this.blendSection        = document.getElementById('dt-blend-section');
        this.blendSectionMobile  = document.getElementById('dt-blend-section-mobile');
        this.colorSection        = document.getElementById('dt-color-section');
        this.colorSectionMobile  = document.getElementById('dt-color-section-mobile');
        this.colorPicker         = document.getElementById('dt-color-picker');
        this.colorPickerMobile   = document.getElementById('dt-color-picker-mobile');
        this.colorSwatches       = document.getElementById('dt-color-swatches');
        this.colorSwatchesMobile = document.getElementById('dt-color-swatches-mobile');

        /* ── Layers Panel DOM refs (Phase 4) ── */
        this.layersList       = document.getElementById('dt-layers-list');
        this.addLayerBtn      = document.getElementById('dt-add-layer-btn');
        this.layerTypeDropdown = document.getElementById('dt-layer-type-dropdown');

        /* ── Modal DOM refs (Phase 4) ── */
        this.fabricModal      = document.getElementById('dt-fabric-modal');
        this.fabricModalGrid  = document.getElementById('dt-fabric-modal-grid');
        this.patternModal     = document.getElementById('dt-pattern-modal');
        this.patternModalGrid = document.getElementById('dt-pattern-modal-grid');

        /* ── Floating toolbar DOM refs (Phase 4) ── */
        this.floatingToolbar  = document.getElementById('dt-floating-toolbar');
        this.ftbColors        = document.getElementById('dt-ftb-colors');
        this.ftbBrushBtn      = document.getElementById('dt-ftb-brush');
        this.ftbSizeSlider    = document.getElementById('dt-ftb-size-slider');
        this.ftbSizeLabel     = document.getElementById('dt-ftb-size-label');

        /* ── Sub-target tracking for SVG semantic coloring ── */
        this._selectedSubTargets = [];

        /* ── State ── */
        this.state = {
            fabricId:  null,
            blendMode: 'multiply',
            opacity:   0.8,
        };

        /* ── Layers System (Phase 4) ── */
        this._layers = [];
        this._activeLayerId = null;
        this._pendingLayerType = null;

        /* ── Auto-Save ── */
        this._initAutoSave();

        /* ── Build UI ── */
        this._buildFabricGrid();
        this._buildPatternGrid();
        this._buildBlendModes();
        this._buildColorPicker();
        this._bindOpacitySlider();
        this._bindDelete();
        this._bindSave();
        this._bindSelection();
        this._bindSubTargetTracking();
        this._bindMobileBottomSheets();
        this._loadSavedDesigns();

        /* ── Drawing Engine (Phase 2) ── */
        this._initDrawingTools();

        /* ── Undo/Redo (Phase 2 fix) ── */
        this._initUndoRedo();

        /* ── Layers System (Phase 4) ── */
        this._initLayersSystem();

        /* ── Recovery & Workspaces ── */
        this._tryRecovery();
        this._initWorkspaces();
    }

    /* ─────────────────────────────────────────────────────────────
       Static factory — fetches assets then constructs instance
       ───────────────────────────────────────────────────────────── */
    static async init() {
        /* ── Read base URL from Laravel-injected meta tag (works on any sub-path) ── */
        var baseMeta = document.querySelector('meta[name="base-url"]');
        var baseUrl  = baseMeta ? baseMeta.content : '';

        try {
            var results = await Promise.all([
                fetch(baseUrl + '/api/patterns').then(function(r) { return r.json(); }),
                fetch(baseUrl + '/api/fabrics').then(function(r) { return r.json(); }),
            ]);
            AssetCatalog.patterns = results[0];
            AssetCatalog.fabrics  = results[1];
            console.log('[Assets] Loaded', AssetCatalog.fabrics.length, 'fabrics,', AssetCatalog.patterns.length, 'patterns');
        } catch (err) {
            console.warn('[Assets] Discovery failed, continuing with empty catalogs.', err);
        }
        return new DesignEngine();
    }

    /* ═══════════════════════════════════════════════════════════════
       PART 2 — Canvas 3:4 Portrait + Responsive Size
       ═══════════════════════════════════════════════════════════════ */
    _resizeCanvas() {
        var isMobile = window.innerWidth < 768;
        var canvasW;

        if (isMobile) {
            canvasW = Math.min(window.innerWidth * 0.90, window.innerHeight * 0.35);
        } else {
            var leftPanel = document.querySelector('.dt-canvas-area');
            if (leftPanel) {
                var panelWidth = leftPanel.clientWidth;
                var panelHeight = leftPanel.clientHeight;
                var maxW = panelWidth * 0.80;
                var maxH = panelHeight * 0.80;
                canvasW = Math.min(maxW, maxH / CANVAS_RATIO);
            } else {
                canvasW = 360;
            }
        }

        canvasW = Math.max(Math.floor(canvasW), 200);
        var canvasH = Math.round(canvasW * CANVAS_RATIO);

        var prevW = this.canvas.getWidth() || canvasW;
        var scale = canvasW / prevW;

        this.canvas.setDimensions({ width: canvasW, height: canvasH });

        var self = this;
        this.canvas.getObjects().forEach(function(obj) {
            if (obj._isFabric) {
                var bgW = obj.getElement().naturalWidth || obj.width || 1;
                var bgH = obj.getElement().naturalHeight || obj.height || 1;
                obj.set({ scaleX: canvasW / bgW, scaleY: canvasH / bgH });
            }
        });

        this.canvas.getObjects().forEach(function(obj) {
            if (obj._isGuideFrame || obj._isFabric) return;
            obj.scaleX *= scale;
            obj.scaleY *= scale;
            obj.left *= scale;
            obj.top *= scale;
            obj.setCoords();
        });

        this._drawGuideFrame();
        this.canvas.renderAll();
    }

    /* ─────────────────────────────────────────────────────────────
       Guide Frame — decorative border to show work area
       ───────────────────────────────────────────────────────────── */
    _drawGuideFrame() {
        if (this._guideFrame) {
            this.canvas.remove(this._guideFrame);
        }

        var w = this.canvas.getWidth();
        var h = this.canvas.getHeight();
        var margin = Math.round(w * 0.05);

        this._guideFrame = new fabric.Rect({
            left: margin,
            top: margin,
            width: w - margin * 2,
            height: h - margin * 2,
            fill: 'transparent',
            stroke: 'rgba(255, 255, 255, 0.35)',
            strokeWidth: 1.5,
            strokeDashArray: [8, 6],
            selectable: false,
            evented: false,
            excludeFromExport: true,
            erasable: false,
            _isGuideFrame: true,
        });

        this.canvas.add(this._guideFrame);
        this.canvas.bringToFront(this._guideFrame);
    }

    /* ─────────────────────────────────────────────────────────────
       Step 1 — Fabric Grid (desktop + mobile)
       ───────────────────────────────────────────────────────────── */
    _buildFabricGrid() {
        var self = this;
        /* Phase 4: dt-fabric-grid removed from desktop HTML — only mobile grid remains */
        if (!AssetCatalog.fabrics.length) {
            var msg = '<p class="dt-step__hint">' + (this.isAr ? 'لا توجد أقمشة متاحة' : 'No fabrics found') + '</p>';
            if (this.fabricGrid) this.fabricGrid.innerHTML = msg;
            if (this.fabricGridMobile) this.fabricGridMobile.innerHTML = msg;
            return;
        }

        AssetCatalog.fabrics.forEach(function(f) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'dt-grid__item';
            btn.dataset.fabricId = f.id;
            btn.innerHTML = '<img class="dt-grid__item-img" src="' + (f.thumb_url || f.url) + '" alt="' + f.id + '" loading="lazy" crossorigin="anonymous">' +
                '<span class="dt-grid__item-label">' + f.id.replace(/-/g, ' ') + '</span>';
            btn.addEventListener('click', function() { self._selectFabric(f); });
            if (self.fabricGrid) self.fabricGrid.appendChild(btn);

            if (self.fabricGridMobile) {
                var btnM = btn.cloneNode(true);
                btnM.addEventListener('click', function() { self._selectFabric(f); });
                self.fabricGridMobile.appendChild(btnM);
            }
        });
    }

    /* ─────────────────────────────────────────────────────────────
       Step 2 — Pattern Grid (desktop + mobile) with Category Tabs
       ───────────────────────────────────────────────────────────── */
    _buildPatternGrid() {
        var self = this;
        /* Phase 4: dt-pattern-grid removed from desktop HTML — only mobile grid remains */
        if (!AssetCatalog.patterns.length) {
            var msg = '<p class="dt-step__hint">' + (this.isAr ? 'لا توجد نقشات متاحة' : 'No patterns found') + '</p>';
            if (this.patternGrid) this.patternGrid.innerHTML = msg;
            if (this.patternGridMobile) this.patternGridMobile.innerHTML = msg;
            return;
        }

        // Pagination state
        this._patternPageSize = 12;
        this._patternPage = 0;
        this._activeCategory = '__all__';

        // Collect unique categories
        var categories = [];
        var seen = {};
        AssetCatalog.patterns.forEach(function(p) {
            var cat = p.category || 'uncategorized';
            if (!seen[cat]) {
                seen[cat] = true;
                categories.push(cat);
            }
        });
        categories.sort();

        // Store pattern buttons for filtering
        this._patternButtons = [];
        this._patternButtonsMobile = [];

        // Build category tabs (desktop)
        if (this.categoryTabs) {
            this.categoryTabs.innerHTML = '';
            var allTab = document.createElement('button');
            allTab.type = 'button';
            allTab.className = 'dt-category-tab is-active';
            allTab.textContent = this.isAr ? 'الكل' : 'All';
            allTab.dataset.category = '__all__';
            allTab.addEventListener('click', function() { self._filterPatterns('__all__'); });
            this.categoryTabs.appendChild(allTab);

            categories.forEach(function(cat) {
                var tab = document.createElement('button');
                tab.type = 'button';
                tab.className = 'dt-category-tab';
                tab.textContent = cat;
                tab.dataset.category = cat;
                tab.addEventListener('click', function() { self._filterPatterns(cat); });
                if (self.categoryTabs) self.categoryTabs.appendChild(tab);
            });
        }

        // Build category tabs (mobile)
        if (this.categoryTabsMobile) {
            this.categoryTabsMobile.innerHTML = '';
            var allTabM = document.createElement('button');
            allTabM.type = 'button';
            allTabM.className = 'dt-category-tab is-active';
            allTabM.textContent = this.isAr ? 'الكل' : 'All';
            allTabM.dataset.category = '__all__';
            allTabM.addEventListener('click', function() { self._filterPatterns('__all__'); });
            this.categoryTabsMobile.appendChild(allTabM);

            categories.forEach(function(cat) {
                var tab = document.createElement('button');
                tab.type = 'button';
                tab.className = 'dt-category-tab';
                tab.textContent = cat;
                tab.dataset.category = cat;
                tab.addEventListener('click', function() { self._filterPatterns(cat); });
                if (self.categoryTabsMobile) self.categoryTabsMobile.appendChild(tab);
            });
        }

        // Build pattern grid items (all hidden initially)
        AssetCatalog.patterns.forEach(function(p) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'dt-grid__item';
            btn.dataset.patternId = p.id;
            btn.dataset.category = p.category || 'uncategorized';
            btn.style.display = 'none';
            btn.innerHTML = '<img class="dt-grid__item-img" src="' + (p.thumb_url || p.url) + '" alt="' + p.id + '" loading="lazy" crossorigin="anonymous">' +
                '<span class="dt-grid__item-label">' + p.id.replace(/-/g, ' ') + '</span>';
            btn.addEventListener('click', function() { self._addPattern(p); });
            if (self.patternGrid) self.patternGrid.appendChild(btn);
            self._patternButtons.push(btn);

            if (self.patternGridMobile) {
                var btnM = btn.cloneNode(true);
                btnM.addEventListener('click', function() { self._addPattern(p); });
                self.patternGridMobile.appendChild(btnM);
                self._patternButtonsMobile.push(btnM);
            }
        });

        // Show first page
        this._showPatternPage();
        this._bindLoadMore();
    }

    /* ─────────────────────────────────────────────────────────────
       Filter pattern grid by category (resets pagination)
       ───────────────────────────────────────────────────────────── */
    _filterPatterns(category) {
        var self = this;

        // Update tab active states (desktop)
        if (this.categoryTabs) {
            this.categoryTabs.querySelectorAll('.dt-category-tab').forEach(function(tab) {
                tab.classList.toggle('is-active', tab.dataset.category === category);
            });
        }
        // Update tab active states (mobile)
        if (this.categoryTabsMobile) {
            this.categoryTabsMobile.querySelectorAll('.dt-category-tab').forEach(function(tab) {
                tab.classList.toggle('is-active', tab.dataset.category === category);
            });
        }

        // Reset pagination
        this._activeCategory = category;
        this._patternPage = 0;

        // Hide all buttons, then show first page of matching category
        this._patternButtons.forEach(function(btn) { btn.style.display = 'none'; });
        this._patternButtonsMobile.forEach(function(btn) { btn.style.display = 'none'; });
        this._showPatternPage();
    }

    /* ─────────────────────────────────────────────────────────────
       Show next page of patterns for the active category
       ───────────────────────────────────────────────────────────── */
    _showPatternPage() {
        var self = this;
        var start = this._patternPage * this._patternPageSize;
        var end = start + this._patternPageSize;
        var count = 0;
        var total = 0;

        // Count total visible for this category
        this._patternButtons.forEach(function(btn) {
            if (self._activeCategory === '__all__' || btn.dataset.category === self._activeCategory) {
                total++;
            }
        });

        // Show next batch (desktop)
        this._patternButtons.forEach(function(btn) {
            if (self._activeCategory === '__all__' || btn.dataset.category === self._activeCategory) {
                if (count >= start && count < end) {
                    btn.style.display = '';
                }
                count++;
            }
        });

        // Show next batch (mobile) — reset counter for independent pagination
        count = 0;
        this._patternButtonsMobile.forEach(function(btn) {
            if (self._activeCategory === '__all__' || btn.dataset.category === self._activeCategory) {
                if (count >= start && count < end) {
                    btn.style.display = '';
                }
                count++;
            }
        });

        this._patternPage++;

        // Show/hide load more buttons
        var hasMore = end < total;
        if (this.loadMoreBtn) this.loadMoreBtn.hidden = !hasMore;
        if (this.loadMoreBtnMobile) this.loadMoreBtnMobile.hidden = !hasMore;
    }

    /* ─────────────────────────────────────────────────────────────
       Bind Load More button clicks
       ───────────────────────────────────────────────────────────── */
    _bindLoadMore() {
        var self = this;
        if (this.loadMoreBtn) {
            this.loadMoreBtn.addEventListener('click', function() { self._showPatternPage(); });
        }
        if (this.loadMoreBtnMobile) {
            this.loadMoreBtnMobile.addEventListener('click', function() { self._showPatternPage(); });
        }
    }

    /* ─────────────────────────────────────────────────────────────
       Step 3 — Blend Mode Buttons (desktop + mobile)
       ───────────────────────────────────────────────────────────── */
    _buildBlendModes() {
        var self = this;
        /* Phase 4: dt-blend-group removed from desktop HTML */
        BLEND_MODES.forEach(function(bm) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'dt-blend-btn' + (bm.id === self.state.blendMode ? ' is-selected' : '');
            btn.dataset.blendId = bm.id;
            btn.textContent = self.isAr ? bm.labelAr : bm.labelEn;
            btn.addEventListener('click', function() { self._selectBlendMode(bm); });
            if (self.blendGroup) self.blendGroup.appendChild(btn);

            if (self.blendGroupMobile) {
                var btnM = btn.cloneNode(true);
                btnM.addEventListener('click', function() { self._selectBlendMode(bm); });
                self.blendGroupMobile.appendChild(btnM);
            }
        });
    }

    /* ─────────────────────────────────────────────────────────────
       Step 3b — Color Picker (swatches + custom input)
       ───────────────────────────────────────────────────────────── */
    _buildColorPicker() {
        var self = this;
        var COLOR_SWATCHES = [
            { hex: '#8B4513', labelAr: 'بني دافئ',     labelEn: 'Warm Brown'   },
            { hex: '#2E5B1E', labelAr: 'أخضر موريس',   labelEn: 'Morris Green' },
            { hex: '#1B3A6B', labelAr: 'أزرق كلاسيكي', labelEn: 'Classic Blue' },
            { hex: '#8B1A1A', labelAr: 'أحمر عميق',    labelEn: 'Deep Red'     },
            { hex: '#6B4C8B', labelAr: 'بنفسجي',       labelEn: 'Purple'       },
            { hex: '#C17D2A', labelAr: 'ذهبي',         labelEn: 'Gold'         },
            { hex: '#2A6B6B', labelAr: 'تيل',          labelEn: 'Teal'         },
            { hex: '#1A1A1A', labelAr: 'أسود',         labelEn: 'Black'        },
        ];

        var containers = [this.colorSwatches];
        if (this.colorSwatchesMobile) containers.push(this.colorSwatchesMobile);

        containers.forEach(function(container) {
            if (!container) return;
            COLOR_SWATCHES.forEach(function(sw) {
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'dt-color-swatch';
                btn.style.backgroundColor = sw.hex;
                btn.title = self.isAr ? sw.labelAr : sw.labelEn;
                btn.dataset.color = sw.hex;
                btn.addEventListener('click', function() { self._applyColorToSelection(sw.hex); });
                container.appendChild(btn);
            });
        });

        if (this.colorPicker) {
            this.colorPicker.addEventListener('input', function(e) {
                self._applyColorToSelection(e.target.value);
                if (self.colorPickerMobile) self.colorPickerMobile.value = e.target.value;
            });
        }
        if (this.colorPickerMobile) {
            this.colorPickerMobile.addEventListener('input', function(e) {
                self._applyColorToSelection(e.target.value);
                if (self.colorPicker) self.colorPicker.value = e.target.value;
            });
        }
    }

    /* ─────────────────────────────────────────────────────────────
       Apply color to selected SVG sub-paths, or entire group as fallback
       ───────────────────────────────────────────────────────────── */
    _applyColorToSelection(color) {
        var active = this.canvas.getActiveObject();
        if (!active) return;

        if (this._selectedSubTargets.length > 0) {
            this._selectedSubTargets.forEach(function(st) {
                st.set('fill', color);
            });
        } else if (active._isSvgGroup && active.type === 'group') {
            active.getObjects().forEach(function(obj) {
                obj.set('fill', color);
            });
        }

        this.canvas.requestRenderAll();
    }

    /* ─────────────────────────────────────────────────────────────
       Smart toggle: show Blend or Color section based on selection
       ───────────────────────────────────────────────────────────── */
    _toggleStep3Sections(activeObj) {
        var isSvg = activeObj && (activeObj._isSvgGroup || (activeObj.group && activeObj.group._isSvgGroup));

        var blendDisplay = isSvg ? 'none' : '';
        var colorDisplay = isSvg ? '' : 'none';

        if (this.blendSection)       this.blendSection.style.display       = blendDisplay;
        if (this.blendSectionMobile) this.blendSectionMobile.style.display = blendDisplay;
        if (this.colorSection)       this.colorSection.style.display       = colorDisplay;
        if (this.colorSectionMobile) this.colorSectionMobile.style.display = colorDisplay;
    }

    /* ─────────────────────────────────────────────────────────────
       Step 4 — Opacity Slider (per-object, desktop + mobile synced)
       ───────────────────────────────────────────────────────────── */
    _bindOpacitySlider() {
        var self = this;
        if (!this.opacitySlider) return;

        this._updateOpacityLabel(parseInt(this.opacitySlider.value, 10));

        var applyOpacity = function(val) {
            var active = self.canvas.getActiveObject();
            if (!active) return;
            var opacity = val / 100;
            active.set({ opacity: opacity });
            self.canvas.requestRenderAll();
        };

        this.opacitySlider.addEventListener('input', function(e) {
            var val = parseInt(e.target.value, 10);
            self._updateOpacityLabel(val);
            if (self.opacitySliderMobile) {
                self.opacitySliderMobile.value = val;
                if (self.opacityLabelMobile) self.opacityLabelMobile.textContent = val + '%';
            }
            applyOpacity(val);
            self._scheduleAutoSave();
        });

        if (this.opacitySliderMobile) {
            this.opacitySliderMobile.addEventListener('input', function(e) {
                var val = parseInt(e.target.value, 10);
                self._updateOpacityLabel(val);
                self.opacitySlider.value = val;
                if (self.opacityLabelMobile) self.opacityLabelMobile.textContent = val + '%';
                applyOpacity(val);
                self._scheduleAutoSave();
            });
        }
    }

    _updateOpacityLabel(val) {
        if (this.opacityLabel) this.opacityLabel.textContent = val + '%';
        if (this.opacityLabelMobile) this.opacityLabelMobile.textContent = val + '%';
    }

    /* ─────────────────────────────────────────────────────────────
       Selection events (enable/disable delete button)
       ───────────────────────────────────────────────────────────── */
    _bindSelection() {
        var self = this;
        this.canvas.on('selection:created', function(e) {
            if (self.deleteBtn) self.deleteBtn.disabled = false;
            self._toggleStep3Sections(e.selected ? e.selected[0] : null);
            self._syncOpacitySlider(e.selected ? e.selected[0] : null);
        });
        this.canvas.on('selection:updated', function(e) {
            if (self.deleteBtn) self.deleteBtn.disabled = false;
            self._toggleStep3Sections(e.selected ? e.selected[0] : null);
            self._syncOpacitySlider(e.selected ? e.selected[0] : null);
        });
        this.canvas.on('selection:cleared', function() {
            if (self.deleteBtn) self.deleteBtn.disabled = true;
            self._toggleStep3Sections(null);
        });
    }

    /* ─────────────────────────────────────────────────────────────
       Sync opacity slider to reflect selected object's opacity
       ───────────────────────────────────────────────────────────── */
    _syncOpacitySlider(obj) {
        if (!obj) return;
        var pct = Math.round((obj.opacity != null ? obj.opacity : 1) * 100);
        if (this.opacitySlider) this.opacitySlider.value = pct;
        if (this.opacitySliderMobile) this.opacitySliderMobile.value = pct;
        this._updateOpacityLabel(pct);
    }

    /* ─────────────────────────────────────────────────────────────
       Sub-target tracking — capture clicked path inside SVG groups
       + visual highlight on the active sub-path
       ───────────────────────────────────────────────────────────── */
    _bindSubTargetTracking() {
        var self = this;
        this.canvas.on('mouse:down', function(opt) {
            if (opt.subTargets && opt.subTargets.length > 0) {
                var multiSelect = opt.e && (opt.e.shiftKey || opt.e.altKey);
                self._highlightSubTarget(opt.subTargets[0], multiSelect);
            } else {
                self._clearSubTargetHighlight();
            }
        });
        this.canvas.on('selection:cleared', function() {
            self._clearSubTargetHighlight();
        });
    }

    _highlightSubTarget(subTarget, addToSelection) {
        var alreadyIdx = this._selectedSubTargets.indexOf(subTarget);

        if (addToSelection) {
            if (alreadyIdx !== -1) {
                subTarget.set({
                    stroke: subTarget._origStroke || null,
                    strokeWidth: subTarget._origStrokeWidth || 0,
                });
                this._selectedSubTargets.splice(alreadyIdx, 1);
            } else {
                subTarget._origStroke = subTarget.stroke || null;
                subTarget._origStrokeWidth = subTarget.strokeWidth || 0;
                subTarget.set({ stroke: '#D4AF37', strokeWidth: 2 });
                this._selectedSubTargets.push(subTarget);
            }
        } else {
            this._clearSubTargetHighlight();
            subTarget._origStroke = subTarget.stroke || null;
            subTarget._origStrokeWidth = subTarget.strokeWidth || 0;
            subTarget.set({ stroke: '#D4AF37', strokeWidth: 2 });
            this._selectedSubTargets.push(subTarget);
        }
        this.canvas.requestRenderAll();
    }

    _clearSubTargetHighlight() {
        if (this._selectedSubTargets.length > 0) {
            this._selectedSubTargets.forEach(function(st) {
                st.set({
                    stroke: st._origStroke || null,
                    strokeWidth: st._origStrokeWidth || 0,
                });
            });
            this._selectedSubTargets = [];
            this.canvas.requestRenderAll();
        }
    }

    /* ─────────────────────────────────────────────────────────────
       Delete active object(s)
       ───────────────────────────────────────────────────────────── */
    _bindDelete() {
        var self = this;

        var doDelete = function() {
            var active = self.canvas.getActiveObject();
            if (!active) return;

            if (active._isGuideFrame) return;
            if (active.type === 'activeSelection') {
                active.forEachObject(function(obj) {
                    if (!obj._isGuideFrame) self.canvas.remove(obj);
                });
                self.canvas.discardActiveObject();
            } else {
                self.canvas.remove(active);
            }

            self._selectedSubTargets = [];
            self.canvas.requestRenderAll();
            self._updateSaveBtn();
        };

        /* Phase 4: dt-delete-btn removed from desktop HTML */
        if (this.deleteBtn) this.deleteBtn.addEventListener('click', doDelete);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Delete' || e.key === 'Del') {
                var tag = (e.target.tagName || '').toLowerCase();
                if (tag === 'input' || tag === 'textarea' || tag === 'select') return;
                doDelete();
            }
        });
    }

    /* ─────────────────────────────────────────────────────────────
       Save button
       ───────────────────────────────────────────────────────────── */
    _bindSave() {
        var self = this;
        this.saveBtns.forEach(function(btn) {
            btn.addEventListener('click', function() { self._save(); });
        });
    }

    /* ─────────────────────────────────────────────────────────────
       Mobile Bottom Sheet Modals
       ───────────────────────────────────────────────────────────── */
    _bindMobileBottomSheets() {
        var self = this;

        var stepButtons = document.querySelectorAll('.dt-mobile-step-btn');
        stepButtons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var step = this.dataset.step;
                self._openBottomSheet(step);
            });
        });

        var sheets = document.querySelectorAll('.dt-bottom-sheet');
        sheets.forEach(function(sheet) {
            var backdrop = sheet.querySelector('.dt-bottom-sheet__backdrop');
            var closeBtn = sheet.querySelector('.dt-bottom-sheet__close');

            if (backdrop) {
                backdrop.addEventListener('click', function() {
                    self._closeBottomSheet(sheet);
                });
            }
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    self._closeBottomSheet(sheet);
                });
            }
        });
    }

    _openBottomSheet(step) {
        var sheet = document.getElementById('dt-bottom-sheet-' + step);
        if (!sheet) return;
        sheet.classList.add('is-open');
    }

    _closeBottomSheet(sheet) {
        sheet.classList.remove('is-open');
    }

    /* ─────────────────────────────────────────────────────────────
       Step 1 — Select Fabric (Phase 4: manual via modal, kept for mobile)
       ───────────────────────────────────────────────────────────── */
    _selectFabric(fabricItem) {
        /* Phase 4: On desktop, this is handled via modal. On mobile, add directly. */
        if (window.innerWidth >= 768) return;
        this._addFabricLayer(fabricItem);
    }

    /* ── Remove existing fabric layer before loading a new one ── */
    _removeExistingFabricLayer() {
        var self = this;
        var toRemove = [];
        this.canvas.getObjects().forEach(function(obj) {
            if (obj._isFabric) toRemove.push(obj);
        });
        toRemove.forEach(function(obj) { self.canvas.remove(obj); });
    }

    /* ─────────────────────────────────────────────────────────────
       Step 2 — Add Pattern instance
       Branches by file type: SVG → loadSVGFromURL, PNG/WebP → Image.fromURL
       ───────────────────────────────────────────────────────────── */
    _addPattern(pattern) {
        var self = this;
        /* Phase 4: Create a layer for this pattern */
        var layerId = 'layer_' + Date.now();
        this._layers.push({
            id: layerId,
            name: pattern.id.replace(/-/g, ' '),
            type: 'pattern',
            visible: true,
            locked: false,
        });
        this._activeLayerId = layerId;

        var patternUrl = pattern.working_url || pattern.url;
        var ext = (patternUrl.split('.').pop() || '').split('?')[0].toLowerCase();
        console.log('[Pattern] Loading:', patternUrl, '(ext:', ext + ')');

        if (ext === 'svg') {
            this._addPatternSvgToLayer(pattern, patternUrl, layerId);
        } else {
            this._addPatternRasterToLayer(pattern, patternUrl, layerId);
        }
    }

    /* ── SVG path: loadSVGFromURL → Group with subTargetCheck ── */
    _addPatternSvg(pattern, patternUrl) {
        var self = this;
        fabric.loadSVGFromURL(patternUrl, function(objects, options) {
            if (!objects || objects.length === 0) {
                console.error('[Pattern SVG] No objects found in:', patternUrl);
                return;
            }

            var group = new fabric.Group(objects, {
                subTargetCheck: true,
            });

            var size = self.canvas.getWidth();
            var grpW = group.width || 100;
            var grpH = group.height || 100;
            var targetSize = size * 0.3;
            var scale = targetSize / Math.max(grpW, grpH);
            console.log('[Pattern SVG] Loaded:', grpW, 'x', grpH, '→ scale:', scale.toFixed(3));

            group.set({
                left:   (size / 2) - (grpW * scale) / 2,
                top:    (size / 2) - (grpH * scale) / 2,
                scaleX: scale,
                scaleY: scale,
                cornerSize:        24,
                touchCornerSize:   36,
                transparentCorners: false,
                cornerColor:       '#D4AF37',
                cornerStrokeColor: '#8b6914',
                borderColor:       'rgba(212, 175, 55, 0.8)',
                borderScaleFactor: 1,
                padding:           4,
                opacity:           self.state.opacity,
                patternId:         pattern.id,
                _isSvgGroup:       true,
            });

            self.canvas.add(group);
            self.canvas.setActiveObject(group);
            self.canvas.requestRenderAll();

            self._hideEmpty();
            self._updateSaveBtn();
        });
    }

    /* ── Raster path (PNG/WebP): existing flow with near-white removal ── */
    _addPatternRaster(pattern, patternUrl) {
        var self = this;
        removeNearWhiteBackground(patternUrl, function(cleanUrl) {
            fabric.Image.fromURL(
                cleanUrl,
                function(img, isError) {
                    if (isError) {
                        console.error('[Pattern] Failed to load image:', patternUrl);
                        return;
                    }
                    var size = self.canvas.getWidth();
                    var imgW = img.getElement().naturalWidth || img.width || 100;
                    var imgH = img.getElement().naturalHeight || img.height || 100;
                    var targetSize = size * 0.3;
                    var scale = targetSize / Math.max(imgW, imgH);
                    console.log('[Pattern Raster] Loaded:', imgW, 'x', imgH, '→ scale:', scale.toFixed(3), 'target:', targetSize);

                    img.set({
                        left:   (size / 2) - (imgW * scale) / 2,
                        top:    (size / 2) - (imgH * scale) / 2,
                        scaleX: scale,
                        scaleY: scale,
                        cornerSize:        24,
                        touchCornerSize:   36,
                        transparentCorners: false,
                        cornerColor:       '#D4AF37',
                        cornerStrokeColor: '#8b6914',
                        borderColor:       'rgba(212, 175, 55, 0.8)',
                        borderScaleFactor: 1,
                        padding:           4,
                        globalCompositeOperation: self.state.blendMode,
                        opacity: self.state.opacity,
                        patternId: pattern.id,
                    });

                    self.canvas.add(img);
                    self.canvas.setActiveObject(img);
                    self.canvas.requestRenderAll();

                    self._hideEmpty();
                    self._updateSaveBtn();
                },
                { crossOrigin: 'anonymous' }
            );
        });
    }

    /* ─────────────────────────────────────────────────────────────
       Step 3 — Select Blend Mode → apply to ALL pattern objects
       ───────────────────────────────────────────────────────────── */
    _selectBlendMode(blendMode) {
        var self = this;
        this.state.blendMode = blendMode.op;

        var allGroups = [this.blendGroup];
        if (this.blendGroupMobile) allGroups.push(this.blendGroupMobile);

        allGroups.forEach(function(group) {
            if (!group) return;
            group.querySelectorAll('.dt-blend-btn').forEach(function(el) {
                el.classList.toggle('is-selected', el.dataset.blendId === blendMode.id);
            });
        });

        this.canvas.getObjects().forEach(function(obj) {
            if (obj._isSvgGroup) return;
            obj.set({ globalCompositeOperation: blendMode.op });
        });
        this.canvas.requestRenderAll();
        this._scheduleAutoSave();
    }

    /* ─────────────────────────────────────────────────────────────
       Helpers
       ───────────────────────────────────────────────────────────── */
    _hideEmpty() {
        var hasFabric = this.state.fabricId || this.canvas.getObjects().some(function(o) { return o._isFabric; });
        if (hasFabric || this.canvas.getObjects().length > 0) {
            this.emptyState.setAttribute('hidden', '');
        }
    }

    _updateSaveBtn() {
        var hasFabric = this.state.fabricId || this.canvas.getObjects().some(function(o) { return o._isFabric; });
        var realObjects = this.canvas.getObjects().filter(function(o) { return !o._isGuideFrame && !o._isFabric; });
        var canSave = hasFabric && realObjects.length > 0;
        this.saveBtns.forEach(function(btn) { btn.disabled = !canSave; });
    }

    /* ═══════════════════════════════════════════════════════════════
       Auto-Save & Recovery
       ═══════════════════════════════════════════════════════════════ */

    _initAutoSave() {
        var self = this;
        this._autoSaveTimer = null;
        var events = ['object:modified', 'object:added', 'object:removed'];
        events.forEach(function(evt) {
            self.canvas.on(evt, function() {
                self._scheduleAutoSave();
            });
        });
        /* ── Phase 2: mark drawing paths and trigger auto-save ── */
        self.canvas.on('path:created', function(e) {
            if (e.path) {
                e.path._isDrawingPath = true;
                /* Phase 4: Assign to active layer */
                if (self._activeLayerId) {
                    e.path._layerId = self._activeLayerId;
                }
            }
            self._scheduleAutoSave();
        });
        /* ── Phase 2 fix: save on tab close ── */
        window.addEventListener('beforeunload', function() {
            self._performAutoSave();
        });
    }

    _scheduleAutoSave() {
        var self = this;
        if (this._autoSaveTimer) clearTimeout(this._autoSaveTimer);
        this._autoSaveTimer = setTimeout(function() {
            self._performAutoSave();
        }, AUTOSAVE_DEBOUNCE);
    }

    _performAutoSave() {
        try {
            var gf = this._guideFrame;
            if (gf) gf.set('visible', false);

            var canvasJson = JSON.stringify(this.canvas.toJSON(['patternId', '_isSvgGroup', 'subTargetCheck', '_isDrawingPath', '_isFabric', '_fabricName', '_locked']));

            if (gf) gf.set('visible', true);
            this.canvas.renderAll();

            var data = {
                canvas_json: canvasJson,
                state: {
                    fabricId: this.state.fabricId,
                    blendMode: this.state.blendMode,
                    opacity: this.state.opacity,
                },
                layers: this._layers,
                activeLayerId: this._activeLayerId,
                workspaceId: this._currentWorkspaceId,
                updatedAt: Date.now(),
            };
            localStorage.setItem(AUTOSAVE_KEY, JSON.stringify(data));

            if (this._workspaces && this._currentWorkspaceId) {
                this._updateCurrentWorkspaceData(canvasJson);
            }
        } catch (e) {
            console.warn('[AutoSave] Failed:', e);
        }
    }

    _updateCurrentWorkspaceData(canvasJson) {
        var self = this;
        var ws = this._workspaces.items.find(function(w) { return w.id === self._workspaces.currentId; });
        if (!ws) return;
        ws.canvas_json = canvasJson;
        ws.state = {
            fabricId: this.state.fabricId,
            blendMode: this.state.blendMode,
            opacity: this.state.opacity,
        };
        ws.layers = this._layers;
        ws.activeLayerId = this._activeLayerId;
        ws.updatedAt = Date.now();
        this._persistWorkspaces(this._workspaces);
    }

    _tryRecovery() {
        var self = this;
        try {
            var raw = localStorage.getItem(AUTOSAVE_KEY);
            if (raw) {
                var data = JSON.parse(raw);
                if (data.canvas_json) {
                    console.log('[Recovery] Found auto-save, restoring...');
                    /* ── [Fix] Block history snapshots during recovery load ── */
                    this._isUndoRedo = true;
                    this.canvas.loadFromJSON(JSON.parse(data.canvas_json), function() {
                        self._restoreRecoveryState(data.state);
                        self._layers = data.layers || [];
                        self._activeLayerId = data.activeLayerId || null;
                        self._restoreBackground();
                        self._syncUIAfterLoad();
                        self._hideEmpty();
                        self._updateSaveBtn();
                        self._renderLayersPanel();
                        /* ── [Fix] Seed history with the recovered state ── */
                        self._isUndoRedo = false;
                        self._saveHistorySnapshot();
                        console.log('[Recovery] Canvas restored from auto-save');
                    });
                    return;
                }
            }

            var ws = this._workspaces.items.find(function(w) { return w.id === self._workspaces.currentId; });
            if (ws && ws.canvas_json) {
                console.log('[Recovery] Loading workspace:', ws.name);
                /* ── [Fix] Block history snapshots during workspace load ── */
                this._isUndoRedo = true;
                this.canvas.loadFromJSON(JSON.parse(ws.canvas_json), function() {
                    if (ws.state) {
                        self.state.fabricId = ws.state.fabricId || null;
                        self.state.blendMode = ws.state.blendMode || 'multiply';
                        self.state.opacity = ws.state.opacity != null ? ws.state.opacity : 0.8;
                    }
                    self._layers = ws.layers || [];
                    self._activeLayerId = ws.activeLayerId || null;
                    self._restoreBackground();
                    self._syncUIAfterLoad();
                    self._hideEmpty();
                    self._updateSaveBtn();
                    self._renderLayersPanel();
                    /* ── [Fix] Seed history with the loaded workspace state ── */
                    self._isUndoRedo = false;
                    self._saveHistorySnapshot();
                    console.log('[Recovery] Workspace restored');
                });
            } else {
                this._drawGuideFrame();
                this.canvas.renderAll();
                /* ── [Fix] Seed history for blank state ── */
                this._saveHistorySnapshot();
            }
        } catch (e) {
            console.warn('[Recovery] Failed:', e);
        }
    }

    _restoreRecoveryState(data) {
        if (data) {
            this.state.fabricId = data.fabricId || null;
            this.state.blendMode = data.blendMode || 'multiply';
            this.state.opacity = data.opacity != null ? data.opacity : 0.8;
        }
    }

    _restoreBackground() {
        var self = this;
        if (!this.state.fabricId) {
            this._drawGuideFrame();
            this.canvas.renderAll();
            return;
        }
        var fabricItem = AssetCatalog.fabrics.find(function(f) { return f.id === self.state.fabricId; });
        if (!fabricItem) {
            this._drawGuideFrame();
            this.canvas.renderAll();
            return;
        }
        var url = fabricItem.working_url || fabricItem.url;
        fabric.Image.fromURL(url, function(img, isError) {
            if (isError) {
                self._drawGuideFrame();
                self.canvas.renderAll();
                return;
            }
            var cW = self.canvas.getWidth();
            var cH = self.canvas.getHeight();
            img.set({
                scaleX: cW / (img.getElement().naturalWidth || 1),
                scaleY: cH / (img.getElement().naturalHeight || 1),
                originX: 'left', originY: 'top', left: 0, top: 0,
                selectable: false,
                evented: false,
                hasControls: false,
                hasBorders: false,
                erasable: false,
                _isFabric: true,
                _fabricName: fabricItem.id.replace(/-/g, ' '),
                _locked: true,
            });
            self.canvas.add(img);
            self.canvas.sendToBack(img);
            self._drawGuideFrame();
            self.canvas.renderAll();
            self._renderLayersPanel();
        }, { crossOrigin: 'anonymous' });
    }

    _syncUIAfterLoad() {
        var self = this;
        var allFabricGrids = [this.fabricGrid];
        if (this.fabricGridMobile) allFabricGrids.push(this.fabricGridMobile);
        allFabricGrids.forEach(function(grid) {
            if (!grid) return;
            grid.querySelectorAll('.dt-grid__item').forEach(function(el) {
                el.classList.toggle('is-selected', el.dataset.fabricId === self.state.fabricId);
            });
        });
        var allBlendGroups = [this.blendGroup];
        if (this.blendGroupMobile) allBlendGroups.push(this.blendGroupMobile);
        allBlendGroups.forEach(function(group) {
            if (!group) return;
            group.querySelectorAll('.dt-blend-btn').forEach(function(el) {
                el.classList.toggle('is-selected', el.dataset.blendId === self.state.blendMode);
            });
        });
        var pct = Math.round(this.state.opacity * 100);
        if (this.opacitySlider) this.opacitySlider.value = pct;
        if (this.opacitySliderMobile) this.opacitySliderMobile.value = pct;
        this._updateOpacityLabel(pct);
    }

    /* ═══════════════════════════════════════════════════════════════
       Workspaces (Tabs)
       ═══════════════════════════════════════════════════════════════ */

    _initWorkspaces() {
        var wsData = this._loadWorkspaces();
        if (!wsData || !wsData.items || wsData.items.length === 0) {
            wsData = { currentId: null, items: [] };
            var defaultWs = this._createWorkspaceObject(
                this.isAr ? 'مساحة عمل 1' : 'Workspace 1'
            );
            wsData.items.push(defaultWs);
            wsData.currentId = defaultWs.id;
            this._persistWorkspaces(wsData);
        }
        this._currentWorkspaceId = wsData.currentId;
        this._workspaces = wsData;
        this._renderWorkspaceTabs();
    }

    _createWorkspaceObject(name) {
        return {
            id: 'ws_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4),
            name: name,
            canvas_json: null,
            state: { fabricId: null, blendMode: 'multiply', opacity: 0.8 },
            updatedAt: Date.now(),
        };
    }

    _loadWorkspaces() {
        try {
            var raw = localStorage.getItem(WORKSPACES_KEY);
            return raw ? JSON.parse(raw) : null;
        } catch (e) {
            console.warn('[Workspaces] Load failed:', e);
            return null;
        }
    }

    _persistWorkspaces(data) {
        try {
            localStorage.setItem(WORKSPACES_KEY, JSON.stringify(data));
        } catch (e) {
            console.warn('[Workspaces] Persist failed:', e);
        }
    }

    _renderWorkspaceTabs() {
        var container = document.getElementById('dt-workspace-tabs');
        if (!container) return;
        var self = this;
        container.innerHTML = '';

        this._workspaces.items.forEach(function(ws) {
            var tab = document.createElement('button');
            tab.type = 'button';
            tab.className = 'dt-ws-tab' + (ws.id === self._workspaces.currentId ? ' is-active' : '');
            tab.dataset.wsId = ws.id;

            var nameSpan = document.createElement('span');
            nameSpan.className = 'dt-ws-tab__name';
            nameSpan.textContent = ws.name;

            nameSpan.addEventListener('dblclick', function(e) {
                e.stopPropagation();
                self._startRename(ws.id, nameSpan);
            });

            tab.appendChild(nameSpan);

            var delBtn = document.createElement('span');
            delBtn.className = 'dt-ws-tab__del';
            delBtn.textContent = '×';
            delBtn.title = self.isAr ? 'حذف مساحة العمل' : 'Delete workspace';
            delBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                self._deleteWorkspace(ws.id);
            });
            tab.appendChild(delBtn);

            tab.addEventListener('click', function() {
                self._switchWorkspace(ws.id);
            });

            container.appendChild(tab);
        });

        if (this._workspaces.items.length < MAX_WORKSPACES) {
            var addBtn = document.createElement('button');
            addBtn.type = 'button';
            addBtn.className = 'dt-ws-tab dt-ws-tab--add';
            addBtn.textContent = '+';
            addBtn.title = this.isAr ? 'إضافة مساحة عمل' : 'Add workspace';
            addBtn.addEventListener('click', function() { self._addWorkspace(); });
            container.appendChild(addBtn);
        }
    }

    _startRename(wsId, nameSpan) {
        var self = this;
        var currentName = nameSpan.textContent;
        nameSpan.contentEditable = true;
        nameSpan.focus();
        var range = document.createRange();
        range.selectNodeContents(nameSpan);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);

        var finishRename = function() {
            nameSpan.contentEditable = false;
            var newName = nameSpan.textContent.trim() || currentName;
            nameSpan.textContent = newName;
            var ws = self._workspaces.items.find(function(w) { return w.id === wsId; });
            if (ws) { ws.name = newName; self._persistWorkspaces(self._workspaces); }
        };

        nameSpan.addEventListener('blur', finishRename, { once: true });
        nameSpan.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); nameSpan.blur(); }
            if (e.key === 'Escape') { nameSpan.textContent = currentName; nameSpan.blur(); }
        });
    }

    _switchWorkspace(id) {
        if (id === this._workspaces.currentId) return;
        var self = this;
        this._saveCurrentWorkspace();
        this.canvas.discardActiveObject();
        this.canvas.getObjects().forEach(function(obj) {
            if (!obj._isGuideFrame) self.canvas.remove(obj);
        });
        self._removeExistingFabricLayer();
        this._workspaces.currentId = id;
        this._currentWorkspaceId = id;
        this._persistWorkspaces(this._workspaces);
        var ws = this._workspaces.items.find(function(w) { return w.id === id; });
        if (ws) this._loadWorkspaceIntoCanvas(ws);
        this._renderWorkspaceTabs();
    }

    _addWorkspace() {
        if (this._workspaces.items.length >= MAX_WORKSPACES) return;
        var self = this;
        var count = this._workspaces.items.length + 1;
        var ws = this._createWorkspaceObject(
            this.isAr ? ('مساحة عمل ' + count) : ('Workspace ' + count)
        );
        this._saveCurrentWorkspace();
        this.canvas.discardActiveObject();
        this.canvas.getObjects().forEach(function(obj) {
            if (!obj._isGuideFrame) self.canvas.remove(obj);
        });
        self._removeExistingFabricLayer();
        this.canvas.renderAll();
        this.state.fabricId = null;
        this.state.blendMode = 'multiply';
        this.state.opacity = 0.8;
        this._workspaces.items.push(ws);
        this._workspaces.currentId = ws.id;
        this._currentWorkspaceId = ws.id;
        this._persistWorkspaces(this._workspaces);
        this._renderWorkspaceTabs();
        this._hideEmpty();
        this._updateSaveBtn();
        this._drawGuideFrame();
        this.canvas.renderAll();
        this._syncUIAfterLoad();
    }

    _deleteWorkspace(id) {
        if (this._workspaces.items.length <= 1) return;
        var self = this;
        if (!confirm(this.isAr ? 'هل أنت متأكد من حذف مساحة العمل هذه؟' : 'Are you sure you want to delete this workspace?')) return;
        var idx = -1;
        this._workspaces.items.forEach(function(w, i) { if (w.id === id) idx = i; });
        if (idx === -1) return;
        this._workspaces.items.splice(idx, 1);
        if (id === this._workspaces.currentId) {
            var targetId = this._workspaces.items[0].id;
            this._workspaces.currentId = targetId;
            this._currentWorkspaceId = targetId;
            this.canvas.discardActiveObject();
            this.canvas.getObjects().forEach(function(obj) {
                if (!obj._isGuideFrame) self.canvas.remove(obj);
            });
            self._removeExistingFabricLayer();
            var ws = this._workspaces.items[0];
            this._loadWorkspaceIntoCanvas(ws);
        }
        this._persistWorkspaces(this._workspaces);
        this._renderWorkspaceTabs();
    }

    _saveCurrentWorkspace() {
        var self = this;
        var ws = this._workspaces.items.find(function(w) { return w.id === self._workspaces.currentId; });
        if (!ws) return;
        try {
            var gf = this._guideFrame;
            if (gf) gf.set('visible', false);
            ws.canvas_json = JSON.stringify(this.canvas.toJSON(['patternId', '_isSvgGroup', 'subTargetCheck', '_isDrawingPath', '_isFabric', '_fabricName', '_locked', '_layerId']));
            if (gf) gf.set('visible', true);
            this.canvas.renderAll();
            ws.state = {
                fabricId: this.state.fabricId,
                blendMode: this.state.blendMode,
                opacity: this.state.opacity,
            };
            ws.layers = this._layers;
            ws.activeLayerId = this._activeLayerId;
            ws.updatedAt = Date.now();
            this._persistWorkspaces(this._workspaces);
        } catch (e) {
            console.warn('[Workspaces] Save current failed:', e);
        }
    }

    _loadWorkspaceIntoCanvas(ws) {
        var self = this;
        if (ws.canvas_json) {
            /* ── [Fix] Block history snapshots during workspace switch load ── */
            this._isUndoRedo = true;
            this.canvas.loadFromJSON(JSON.parse(ws.canvas_json), function() {
                if (ws.state) {
                    self.state.fabricId = ws.state.fabricId || null;
                    self.state.blendMode = ws.state.blendMode || 'multiply';
                    self.state.opacity = ws.state.opacity != null ? ws.state.opacity : 0.8;
                }
                self._layers = ws.layers || [];
                self._activeLayerId = ws.activeLayerId || null;
                self._restoreBackground();
                self._syncUIAfterLoad();
                self._hideEmpty();
                self._updateSaveBtn();
                self._renderLayersPanel();
                /* ── [Fix] Seed clean history for this workspace ── */
                self._history = [];
                self._historyIndex = -1;
                self._isUndoRedo = false;
                self._saveHistorySnapshot();
            });
        } else {
            this.state.fabricId = null;
            this.state.blendMode = (ws.state && ws.state.blendMode) || 'multiply';
            this.state.opacity = (ws.state && ws.state.opacity != null) ? ws.state.opacity : 0.8;
            self._removeExistingFabricLayer();
            this._drawGuideFrame();
            this.canvas.renderAll();
            this._syncUIAfterLoad();
            this._hideEmpty();
            this._updateSaveBtn();
            /* ── [Fix] Seed clean history for blank workspace ── */
            this._history = [];
            this._historyIndex = -1;
            this._saveHistorySnapshot();
        }
    }

    /* ─────────────────────────────────────────────────────────────
       Saved Designs Gallery
       ───────────────────────────────────────────────────────────── */
    async _loadSavedDesigns() {
        var self = this;
        try {
            var res = await fetch('/designs');
            if (!res.ok) return;
            var designs = await res.json();
            self._renderSavedDesigns(designs);
        } catch (err) {
            console.error('Failed to load saved designs:', err);
        }
    }

    _renderSavedDesigns(designs) {
        var self = this;
        /* Phase 4: dt-saved-gallery may not exist in current HTML */
        if (!designs || designs.length === 0) {
            if (this.savedGallery) this.savedGallery.hidden = true;
            this.proceedBtns.forEach(function(btn) { btn.style.display = 'none'; });
            return;
        }

        if (this.savedGallery) this.savedGallery.hidden = false;
        this.proceedBtns.forEach(function(btn) { btn.style.display = 'flex'; });
        if (!this.savedGrid) return;
        this.savedGrid.innerHTML = '';

        designs.forEach(function(design) {
            var wrap = document.createElement('div');
            wrap.className = 'dt-grid__item';
            wrap.style.position = 'relative';

            var img = document.createElement('img');
            img.src = design.preview_image;
            img.className = 'dt-grid__item-img';
            img.style.cursor = 'pointer';
            img.addEventListener('click', function() { self._loadDesignIntoCanvas(design); });

            var delBtn = document.createElement('button');
            delBtn.innerHTML = '🗑️';
            delBtn.style.cssText = 'position:absolute;top:5px;right:5px;background:rgba(255,0,0,0.7);color:white;border:none;border-radius:50%;width:24px;height:24px;cursor:pointer;';

            delBtn.addEventListener('click', async function(e) {
                e.stopPropagation();
                if (confirm(self.isAr ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete this design?')) {
                    await self._deleteSavedDesign(design.id);
                }
            });

            wrap.appendChild(img);
            wrap.appendChild(delBtn);
            self.savedGrid.appendChild(wrap);
        });
    }

    async _deleteSavedDesign(id) {
        try {
            var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
            var res = await fetch('/designs/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            if (res.ok) {
                this._loadSavedDesigns();
            }
        } catch (err) {
            console.error('Delete failed:', err);
        }
    }

    _loadDesignIntoCanvas(design) {
        var self = this;
        if (!design.canvas_json) return;

        this._removeExistingFabricLayer();
        this.canvas.backgroundImage = null;

        /* Restore layers from saved design */
        try {
            this._layers = design.layers ? JSON.parse(design.layers) : [];
        } catch(e) {
            this._layers = [];
        }
        this._activeLayerId = design.activeLayerId || null;

        this.canvas.loadFromJSON(design.canvas_json, function() {
            self.canvas.requestRenderAll();
            self.state.fabricId = design.fabric_id;
            self.state.blendMode = design.blend_mode;
            self.state.opacity = parseFloat(design.opacity);

            /* Restore fabric layer lockdown if found */
            self.canvas.getObjects().forEach(function(obj) {
                if (obj._isFabric) {
                    obj.set({
                        selectable: false,
                        evented: false,
                        hasControls: false,
                        hasBorders: false,
                        _locked: true,
                    });
                }
            });

            /* Send fabric to back */
            self.canvas.getObjects().forEach(function(obj) {
                if (obj._isFabric) self.canvas.sendToBack(obj);
            });

            self._drawGuideFrame();
            self.canvas.renderAll();
            self._renderLayersPanel();

            // Sync opacity slider to first pattern object if available
            var objs = self.canvas.getObjects().filter(function(o) { return !o._isGuideFrame && !o._isFabric; });
            if (objs.length > 0) {
                self.canvas.setActiveObject(objs[0]);
                self._syncOpacitySlider(objs[0]);
            } else {
                self.opacitySlider.value = Math.round(self.state.opacity * 100);
                self._updateOpacityLabel(self.opacitySlider.value);
                if (self.opacitySliderMobile) {
                    self.opacitySliderMobile.value = Math.round(self.state.opacity * 100);
                }
            }

            var allBlendGroups = [self.blendGroup];
            if (self.blendGroupMobile) allBlendGroups.push(self.blendGroupMobile);
            allBlendGroups.forEach(function(group) {
                if (!group) return;
                group.querySelectorAll('.dt-blend-btn').forEach(function(el) {
                    el.classList.toggle('is-selected', el.dataset.blendId === self.state.blendMode);
                });
            });

            var allFabricGrids = [self.fabricGrid];
            if (self.fabricGridMobile) allFabricGrids.push(self.fabricGridMobile);
            allFabricGrids.forEach(function(grid) {
                if (!grid) return;
                grid.querySelectorAll('.dt-grid__item').forEach(function(el) {
                    el.classList.toggle('is-selected', el.dataset.fabricId === self.state.fabricId);
                });
            });

            self._hideEmpty();
            self._updateSaveBtn();
        });
    }

    /* ─────────────────────────────────────────────────────────────
       Save — POST to /designs
       ───────────────────────────────────────────────────────────── */
    async _save() {
        var self = this;
        var hasFabric = this.state.fabricId || this.canvas.getObjects().some(function(o) { return o._isFabric; });
        var realObjects = this.canvas.getObjects().filter(function(o) { return !o._isGuideFrame && !o._isFabric; });
        if (!hasFabric || realObjects.length < 1) return;

        this.saveBtns.forEach(function(btn) {
            btn.disabled = true;
            btn.textContent = self.isAr ? 'جاري الحفظ...' : 'Saving...';
        });

        try {
            var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

            var patternIds = this.canvas.getObjects().filter(function(obj) { return !obj._isGuideFrame; }).map(function(obj) { return obj.patternId; }).filter(Boolean);

            var activeObj = this.canvas.getActiveObject();
            var currentOpacity = (activeObj && activeObj.opacity != null) ? activeObj.opacity : this.state.opacity;

            var payload = {
                fabric_id:    this.state.fabricId,
                blend_mode:   this.state.blendMode,
                opacity:      currentOpacity,
                patterns_used: JSON.stringify(patternIds),
                canvas_json:  JSON.stringify(this.canvas.toJSON(['patternId', '_isSvgGroup', 'subTargetCheck', '_isDrawingPath', '_isFabric', '_fabricName', '_locked', '_layerId'])),
                layers:       JSON.stringify(this._layers),
                activeLayerId: this._activeLayerId,
                preview_image: (function() {
                    var gf = self._guideFrame;
                    if (gf) gf.set('visible', false);
                    var dataUrl = self.canvas.toDataURL({ format: 'png' });
                    if (gf) gf.set('visible', true);
                    self.canvas.renderAll();
                    return dataUrl;
                })(),
            };

            var res = await fetch('/designs', {
                method:  'POST',
                headers: {
                    'Accept':       'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload),
            });

            if (!res.ok) throw new Error('Save failed: ' + res.status);

            this.saveBtns.forEach(function(btn) { btn.textContent = self.isAr ? 'تم الحفظ!' : 'Saved!'; });
            setTimeout(function() {
                self.saveBtns.forEach(function(btn) {
                    btn.textContent = self.isAr ? 'حفظ التصميم' : 'Save Design';
                    btn.disabled = false;
                });
            }, 2000);

            this._loadSavedDesigns();

        } catch (err) {
            console.error('Design save error:', err);
            this.saveBtns.forEach(function(btn) {
                btn.disabled = false;
                btn.textContent = self.isAr ? 'حدث خطأ، حاولي مجدداً' : 'Error — try again';
            });
            setTimeout(function() {
                self.saveBtns.forEach(function(btn) {
                    btn.textContent = self.isAr ? 'حفظ التصميم' : 'Save Design';
                });
                self._updateSaveBtn();
            }, 2500);
        }
    }

    /* ═══════════════════════════════════════════════════════════════
       Phase 2 fix — Undo/Redo System
       ═══════════════════════════════════════════════════════════════ */

    _initUndoRedo() {
        var self = this;
        this._history = [];
        this._historyIndex = -1;
        this._historyMax = 50;
        /* ── [Fix] Start as true so _tryRecovery (called after this) controls seeding ── */
        this._isUndoRedo = true;
        this._undoTimer = null;

        /* Keyboard shortcuts */
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                if (e.key === 'z' && !e.shiftKey) {
                    e.preventDefault();
                    self._undo();
                } else if ((e.key === 'z' && e.shiftKey) || e.key === 'y') {
                    e.preventDefault();
                    self._redo();
                }
            }
        });

        /* Button clicks */
        if (this._undoBtn) {
            this._undoBtn.addEventListener('click', function() { self._undo(); });
        }
        if (this._redoBtn) {
            this._redoBtn.addEventListener('click', function() { self._redo(); });
        }

        /* Auto-save history on every canvas change */
        var evts = ['object:modified', 'object:added', 'object:removed', 'path:created'];
        evts.forEach(function(evt) {
            self.canvas.on(evt, function() {
                self._scheduleHistorySave();
            });
        });

        this._updateUndoButtons();
    }

    _scheduleHistorySave() {
        var self = this;
        if (this._undoTimer) clearTimeout(this._undoTimer);
        this._undoTimer = setTimeout(function() {
            self._saveHistorySnapshot();
        }, 300);
    }

    _saveHistorySnapshot() {
        if (this._isUndoRedo) return;

        /* Remove any future states after current index */
        this._history = this._history.slice(0, this._historyIndex + 1);

        /* Serialize canvas (hide guide frame during snapshot) */
        var gf = this._guideFrame;
        if (gf) gf.set('visible', false);
        var state = JSON.stringify(
            this.canvas.toJSON(['patternId', '_isSvgGroup', 'subTargetCheck', '_isDrawingPath', '_isFabric', '_fabricName', '_locked', '_layerId'])
        );
        if (gf) gf.set('visible', true);
        this.canvas.renderAll();

        this._history.push(state);

        /* Trim if over max */
        if (this._history.length > this._historyMax) {
            this._history.shift();
        }
        this._historyIndex = this._history.length - 1;

        this._updateUndoButtons();
    }

    _undo() {
        if (this._historyIndex <= 0) return;
        this._historyIndex--;
        this._loadHistoryState();
    }

    _redo() {
        if (this._historyIndex >= this._history.length - 1) return;
        this._historyIndex++;
        this._loadHistoryState();
    }

    _loadHistoryState() {
        var self = this;
        this._isUndoRedo = true;
        var state = this._history[this._historyIndex];
        this.canvas.loadFromJSON(JSON.parse(state), function() {
            self._restoreBackground();
            self._isUndoRedo = false;
            self._updateUndoButtons();
            self.canvas.renderAll();
        });
    }

    _updateUndoButtons() {
        if (this._undoBtn) this._undoBtn.disabled = this._historyIndex <= 0;
        if (this._redoBtn) this._redoBtn.disabled = this._historyIndex >= this._history.length - 1;
    }

    /* ═══════════════════════════════════════════════════════════════
       Phase 2 — Freehand Drawing Engine
       ═══════════════════════════════════════════════════════════════ */

    _initDrawingTools() {
        var self = this;

        /* ── DOM refs ── */
        this._drawModeBtn      = document.getElementById('dt-draw-mode');
        this._brushBtns        = document.querySelectorAll('.dt-brush-btn');
        this._drawSettings     = document.getElementById('dt-draw-settings');
        this._drawSizeWrap     = document.getElementById('dt-draw-size-wrap');
        this._drawColorWrap    = document.getElementById('dt-draw-color-wrap');
        this._eraserSizeWrap   = document.getElementById('dt-eraser-size-wrap');
        this._brushSizeInput   = document.getElementById('dt-brush-size');
        this._brushColorInput  = document.getElementById('dt-brush-color');
        this._eraserSizeInput  = document.getElementById('dt-eraser-size');
        this._brushSizeLabel   = document.getElementById('dt-brush-size-label');
        this._eraserSizeLabel  = document.getElementById('dt-eraser-size-label');

        /* ── Undo/Redo refs ── */
        this._undoBtn = document.getElementById('dt-undo-btn');
        this._redoBtn = document.getElementById('dt-redo-btn');

        /* ── State ── */
        this._isDrawingMode = false;
        this._activeBrush   = 'pencil';

        /* ── Cursor preview element ── */
        this._cursorPreview = document.createElement('div');
        this._cursorPreview.className = 'dt-cursor-preview';
        document.body.appendChild(this._cursorPreview);

        /* ── Canvas mouse events for cursor preview ── */
        this.canvas.on('mouse:move', function(opt) {
            if (self._isDrawingMode && self._cursorPreview && opt.e) {
                var pointer = self.canvas.getPointer(opt.e);
                var canvasPos = self.canvas.wrapperEl.getBoundingClientRect();
                var size;
                if (self._activeBrush === 'eraser') {
                    size = self._eraserSizeInput ? parseInt(self._eraserSizeInput.value, 10) : (self.ftbSizeSlider ? parseInt(self.ftbSizeSlider.value, 10) : 10);
                } else {
                    size = self._brushSizeInput ? parseInt(self._brushSizeInput.value, 10) : (self.ftbSizeSlider ? parseInt(self.ftbSizeSlider.value, 10) : 5);
                }
                self._updateCursorPreview(canvasPos, pointer, size);
            }
        });

        this.canvas.on('mouse:down', function() {
            if (self._cursorPreview) self._cursorPreview.style.display = 'none';
        });

        this.canvas.on('mouse:up', function() {
            if (self._isDrawingMode && self._cursorPreview) {
                self._cursorPreview.style.display = 'block';
            }
        });

        /* ── Mode toggle ── */
        this._drawModeBtn.addEventListener('click', function() {
            self._toggleDrawingMode();
        });

        /* ── Brush selection ── */
        this._brushBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                self._selectBrush(this.dataset.brush);
            });
        });

        /* ── Brush size slider ── */
        if (this._brushSizeInput) {
            this._brushSizeInput.addEventListener('input', function() {
                var val = parseInt(this.value, 10);
                self._updateBrushSize(val);
                if (self._brushSizeLabel) self._brushSizeLabel.textContent = val;
            });
        }

        /* ── Brush color picker ── */
        if (this._brushColorInput) {
            this._brushColorInput.addEventListener('input', function() {
                self._updateBrushColor(this.value);
            });
        }

        /* ── Eraser size slider ── */
        if (this._eraserSizeInput) {
            this._eraserSizeInput.addEventListener('input', function() {
                var val = parseInt(this.value, 10);
                self._updateEraserSize(val);
                if (self._eraserSizeLabel) self._eraserSizeLabel.textContent = val;
            });
        }

        /* ── Hide all settings initially (Phase 4: elements may not exist) ── */
        if (this._drawSettings) this._drawSettings.hidden = true;
        if (this._drawSizeWrap) this._drawSizeWrap.hidden = true;
        if (this._drawColorWrap) this._drawColorWrap.hidden = true;
        if (this._eraserSizeWrap) this._eraserSizeWrap.hidden = true;
    }

    /* ─────────────────────────────────────────────────────────────
       Cursor preview: positions a circle at mouse pointer
       ───────────────────────────────────────────────────────────── */
    _updateCursorPreview(canvasPos, pointer, size) {
        this._cursorPreview.style.width = size + 'px';
        this._cursorPreview.style.height = size + 'px';
        this._cursorPreview.style.left = (canvasPos.left + pointer.x) + 'px';
        this._cursorPreview.style.top = (canvasPos.top + pointer.y) + 'px';
        this._cursorPreview.style.display = 'block';
    }

    /* ─────────────────────────────────────────────────────────────
       Mode toggle: Selection ↔ Drawing
       ───────────────────────────────────────────────────────────── */
    _toggleDrawingMode() {
        this._isDrawingMode = !this._isDrawingMode;
        this.canvas.isDrawingMode = this._isDrawingMode;

        this._drawModeBtn.classList.toggle('is-drawing', this._isDrawingMode);
        this._drawModeBtn.title = this.isAr
            ? (this._isDrawingMode ? 'وضع الرسم' : 'وضع التحديد')
            : (this._isDrawingMode ? 'Drawing Mode' : 'Selection Mode');

        /* Phase 4: Show/hide floating toolbar */
        this._showFloatingToolbar(this._isDrawingMode);

        if (this._isDrawingMode) {
            this._selectBrush(this._activeBrush);
        } else {
            this.canvas.freeDrawingBrush = null;
            this.canvas.selection = true;
            if (this._drawSettings) this._drawSettings.hidden = true;
            if (this._drawSizeWrap) this._drawSizeWrap.hidden = true;
            if (this._drawColorWrap) this._drawColorWrap.hidden = true;
            if (this._eraserSizeWrap) this._eraserSizeWrap.hidden = true;
            if (this._cursorPreview) this._cursorPreview.style.display = 'none';
        }

        this.canvas.renderAll();
    }

    /* ─────────────────────────────────────────────────────────────
       Select brush type: pencil | spray | eraser
       ───────────────────────────────────────────────────────────── */
    _selectBrush(brushType) {
        this._activeBrush = brushType;
        this._isDrawingMode = true;
        this.canvas.isDrawingMode = true;
        this.canvas.selection = false;

        /* Update toggle button state */
        this._drawModeBtn.classList.add('is-drawing');
        this._drawModeBtn.title = this.isAr
            ? (brushType === 'eraser' ? 'الممحاة' : 'الرسم')
            : (brushType === 'eraser' ? 'Eraser' : 'Drawing Mode');

        /* Update brush button active states */
        this._brushBtns.forEach(function(btn) {
            btn.classList.toggle('is-active', btn.dataset.brush === brushType);
        });

        /* Hide all settings then show relevant ones */
        if (this._drawSizeWrap) this._drawSizeWrap.hidden = true;
        if (this._drawColorWrap) this._drawColorWrap.hidden = true;
        if (this._eraserSizeWrap) this._eraserSizeWrap.hidden = true;

        if (brushType === 'eraser') {
            /* ── EraserBrush (via fabric-eraser plugin) ── */
            this.canvas.freeDrawingBrush = new fabric.EraserBrush(this.canvas);
            if (this._drawSettings) this._drawSettings.hidden = false;
            if (this._eraserSizeWrap) this._eraserSizeWrap.hidden = false;
            if (this._eraserSizeInput) {
                var erVal = parseInt(this._eraserSizeInput.value, 10);
                this._updateEraserSize(erVal);
                if (this._eraserSizeLabel) this._eraserSizeLabel.textContent = erVal;
            }
            /* Phase 4: Sync floating toolbar size slider */
            if (this.ftbSizeSlider) {
                var erFtb = parseInt(this.ftbSizeSlider.value, 10);
                this._updateEraserSize(erFtb);
            }
        } else {
            /* ── Pencil or Spray brush ── */
            this.canvas.freeDrawingBrush = brushType === 'spray'
                ? new fabric.SprayBrush(this.canvas)
                : new fabric.PencilBrush(this.canvas);
            if (this._drawSettings) this._drawSettings.hidden = false;
            if (this._drawSizeWrap) this._drawSizeWrap.hidden = false;
            if (this._drawColorWrap) this._drawColorWrap.hidden = false;
            if (this._brushSizeInput) {
                var brVal = parseInt(this._brushSizeInput.value, 10);
                this._updateBrushSize(brVal);
                if (this._brushSizeLabel) this._brushSizeLabel.textContent = brVal;
            }
            if (this._brushColorInput) {
                this._updateBrushColor(this._brushColorInput.value);
            }
            /* Phase 4: Sync with floating toolbar */
            if (this.ftbSizeSlider) {
                var brFtb = parseInt(this.ftbSizeSlider.value, 10);
                this._updateBrushSize(brFtb);
            }
        }

        this.canvas.renderAll();
    }

    /* ─────────────────────────────────────────────────────────────
       Brush settings
       ───────────────────────────────────────────────────────────── */
    _updateBrushSize(val) {
        if (this.canvas.freeDrawingBrush) {
            this.canvas.freeDrawingBrush.width = val;
        }
    }

    _updateBrushColor(color) {
        if (this.canvas.freeDrawingBrush) {
            this.canvas.freeDrawingBrush.color = color;
        }
    }

    _updateEraserSize(val) {
        if (this.canvas.freeDrawingBrush) {
            this.canvas.freeDrawingBrush.width = val;
        }
    }

    /* ═══════════════════════════════════════════════════════════════
       Phase 4 — Layers System (Manual Layer Management)
       ═══════════════════════════════════════════════════════════════ */

    _initLayersSystem() {
        var self = this;

        /* Bind canvas events to auto-update layers panel */
        var layerEvents = ['object:added', 'object:removed', 'object:modified'];
        layerEvents.forEach(function(evt) {
            self.canvas.on(evt, function() {
                if (!self._isUndoRedo) {
                    self._renderLayersPanel();
                }
            });
        });

        /* Add Layer button */
        if (this.addLayerBtn) {
            this.addLayerBtn.addEventListener('click', function() {
                self._toggleLayerDropdown();
            });
        }

        /* Layer type dropdown options */
        var typeOptions = document.querySelectorAll('.dt-layer-type-option');
        typeOptions.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var type = this.dataset.type;
                self._pendingLayerType = type;
                self._hideLayerDropdown();
                self._handleAddLayer(type);
            });
        });

        /* Modal close buttons */
        var modalCloses = document.querySelectorAll('.dt-modal-close');
        modalCloses.forEach(function(btn) {
            btn.addEventListener('click', function() {
                self._closeAllModals();
            });
        });

        /* Modal backdrop clicks */
        var modals = document.querySelectorAll('.dt-modal-overlay');
        modals.forEach(function(modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) self._closeAllModals();
            });
        });

        /* Floating toolbar */
        this._initFloatingToolbar();

        /* Initial render */
        this._renderLayersPanel();
    }

    /* ── Toggle layer type dropdown ── */
    _toggleLayerDropdown() {
        if (this.layerTypeDropdown) {
            this.layerTypeDropdown.hidden = !this.layerTypeDropdown.hidden;
        }
    }

    _hideLayerDropdown() {
        if (this.layerTypeDropdown) this.layerTypeDropdown.hidden = true;
    }

    /* ── Handle adding a new layer ── */
    _handleAddLayer(type) {
        var self = this;
        switch (type) {
            case 'fabric':
                this._openFabricModal();
                break;
            case 'pattern':
                this._openPatternModal();
                break;
            case 'drawing':
                this._addDrawingLayer();
                break;
        }
    }

    /* ── Open fabric selection modal ── */
    _openFabricModal() {
        var self = this;
        if (!this.fabricModal || !this.fabricModalGrid) return;
        this.fabricModalGrid.innerHTML = '';

        AssetCatalog.fabrics.forEach(function(f) {
            var item = document.createElement('div');
            item.className = 'dt-modal-grid-item';
            item.innerHTML = '<img src="' + (f.thumb_url || f.url) + '" alt="' + f.id + '" loading="lazy" crossorigin="anonymous">';
            item.addEventListener('click', function() {
                self._closeAllModals();
                self._addFabricLayer(f);
            });
            self.fabricModalGrid.appendChild(item);
        });

        this.fabricModal.classList.add('is-open');
    }

    /* ── Open pattern selection modal ── */
    _openPatternModal() {
        var self = this;
        if (!this.patternModal || !this.patternModalGrid) return;
        this.patternModalGrid.innerHTML = '';

        AssetCatalog.patterns.forEach(function(p) {
            var item = document.createElement('div');
            item.className = 'dt-modal-grid-item';
            item.innerHTML = '<img src="' + (p.thumb_url || p.url) + '" alt="' + p.id + '" loading="lazy" crossorigin="anonymous">';
            item.addEventListener('click', function() {
                self._closeAllModals();
                self._addPatternLayer(p);
            });
            self.patternModalGrid.appendChild(item);
        });

        this.patternModal.classList.add('is-open');
    }

    _closeAllModals() {
        var modals = document.querySelectorAll('.dt-modal-overlay');
        modals.forEach(function(m) { m.classList.remove('is-open'); });
    }

    /* ── Add a fabric layer ── */
    _addFabricLayer(fabricItem) {
        var self = this;
        var layerId = 'layer_' + Date.now();
        var layerName = fabricItem.id.replace(/-/g, ' ');

        var fabricUrl = fabricItem.working_url || fabricItem.url;
        console.log('[Layers] Adding fabric layer:', layerName);

        fabric.Image.fromURL(fabricUrl, function(img, isError) {
            if (isError) {
                console.error('[Layers] Failed to load fabric:', fabricUrl);
                return;
            }
            var cW = self.canvas.getWidth();
            var cH = self.canvas.getHeight();
            var imgW = img.getElement().naturalWidth || img.width || 1;
            var imgH = img.getElement().naturalHeight || img.height || 1;

            img.set({
                scaleX: cW / imgW,
                scaleY: cH / imgH,
                originX: 'left',
                originY: 'top',
                left: 0,
                top: 0,
                selectable: false,
                evented: false,
                hasControls: false,
                hasBorders: false,
                erasable: false,
                _isFabric: true,
                _fabricName: layerName,
                _locked: true,
                _layerId: layerId,
            });

            self.canvas.add(img);
            self.canvas.sendToBack(img);
            self._drawGuideFrame();
            self.canvas.renderAll();

            /* Create layer entry */
            self._layers.push({
                id: layerId,
                name: layerName,
                type: 'fabric',
                visible: true,
                locked: true,
            });

            self._activeLayerId = layerId;
            self._renderLayersPanel();
            self._hideEmpty();
            self._updateSaveBtn();
            self._scheduleAutoSave();
        }, { crossOrigin: 'anonymous' });
    }

    /* ── Add a pattern layer ── */
    _addPatternLayer(pattern) {
        var self = this;
        var layerId = 'layer_' + Date.now();
        var layerName = pattern.id.replace(/-/g, ' ');

        /* Create layer entry first */
        this._layers.push({
            id: layerId,
            name: layerName,
            type: 'pattern',
            visible: true,
            locked: false,
        });

        this._activeLayerId = layerId;

        /* Add pattern to canvas */
        var patternUrl = pattern.working_url || pattern.url;
        var ext = (patternUrl.split('.').pop() || '').split('?')[0].toLowerCase();

        if (ext === 'svg') {
            this._addPatternSvgToLayer(pattern, patternUrl, layerId);
        } else {
            this._addPatternRasterToLayer(pattern, patternUrl, layerId);
        }
    }

    _addPatternSvgToLayer(pattern, patternUrl, layerId) {
        var self = this;
        fabric.loadSVGFromURL(patternUrl, function(objects, options) {
            if (!objects || objects.length === 0) return;

            var group = new fabric.Group(objects, { subTargetCheck: true });
            var size = self.canvas.getWidth();
            var grpW = group.width || 100;
            var grpH = group.height || 100;
            var targetSize = size * 0.3;
            var scale = targetSize / Math.max(grpW, grpH);

            group.set({
                left: (size / 2) - (grpW * scale) / 2,
                top: (size / 2) - (grpH * scale) / 2,
                scaleX: scale,
                scaleY: scale,
                cornerSize: 24,
                touchCornerSize: 36,
                transparentCorners: false,
                cornerColor: '#D4AF37',
                cornerStrokeColor: '#8b6914',
                borderColor: 'rgba(212, 175, 55, 0.8)',
                borderScaleFactor: 1,
                padding: 4,
                opacity: self.state.opacity,
                patternId: pattern.id,
                _isSvgGroup: true,
                _layerId: layerId,
            });

            self.canvas.add(group);
            self.canvas.setActiveObject(group);
            self.canvas.renderAll();
            self._renderLayersPanel();
            self._hideEmpty();
            self._updateSaveBtn();
        });
    }

    _addPatternRasterToLayer(pattern, patternUrl, layerId) {
        var self = this;
        removeNearWhiteBackground(patternUrl, function(cleanUrl) {
            fabric.Image.fromURL(cleanUrl, function(img, isError) {
                if (isError) return;
                var size = self.canvas.getWidth();
                var imgW = img.getElement().naturalWidth || img.width || 100;
                var imgH = img.getElement().naturalHeight || img.height || 100;
                var targetSize = size * 0.3;
                var scale = targetSize / Math.max(imgW, imgH);

                img.set({
                    left: (size / 2) - (imgW * scale) / 2,
                    top: (size / 2) - (imgH * scale) / 2,
                    scaleX: scale,
                    scaleY: scale,
                    cornerSize: 24,
                    touchCornerSize: 36,
                    transparentCorners: false,
                    cornerColor: '#D4AF37',
                    cornerStrokeColor: '#8b6914',
                    borderColor: 'rgba(212, 175, 55, 0.8)',
                    borderScaleFactor: 1,
                    padding: 4,
                    globalCompositeOperation: self.state.blendMode,
                    opacity: self.state.opacity,
                    patternId: pattern.id,
                    _layerId: layerId,
                });

                self.canvas.add(img);
                self.canvas.setActiveObject(img);
                self.canvas.renderAll();
                self._renderLayersPanel();
                self._hideEmpty();
                self._updateSaveBtn();
            }, { crossOrigin: 'anonymous' });
        });
    }

    /* ── Add a drawing layer ── */
    _addDrawingLayer() {
        var layerId = 'layer_' + Date.now();
        this._layers.push({
            id: layerId,
            name: this.isAr ? 'رسم حر' : 'Freehand',
            type: 'drawing',
            visible: true,
            locked: false,
        });
        this._activeLayerId = layerId;

        /* Activate drawing mode */
        if (!this._isDrawingMode) {
            this._toggleDrawingMode();
        }
        this._selectBrush('pencil');
        this._renderLayersPanel();
    }

    /* ── Floating Toolbar ── */
    _initFloatingToolbar() {
        var self = this;

        /* Color buttons */
        if (this.ftbColors) {
            this.ftbColors.querySelectorAll('.dt-ftb-color').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    self.ftbColors.querySelectorAll('.dt-ftb-color').forEach(function(b) { b.classList.remove('is-active'); });
                    this.classList.add('is-active');
                    if (self._brushColorInput) self._brushColorInput.value = this.dataset.color;
                    self._updateBrushColor(this.dataset.color);
                });
            });
        }

        /* Brush button */
        if (this.ftbBrushBtn) {
            this.ftbBrushBtn.addEventListener('click', function() {
                if (!self._isDrawingMode) self._toggleDrawingMode();
                self._selectBrush('pencil');
            });
        }

        /* Size slider */
        if (this.ftbSizeSlider) {
            this.ftbSizeSlider.addEventListener('input', function() {
                var val = parseInt(this.value, 10);
                if (self.ftbSizeLabel) self.ftbSizeLabel.textContent = val + 'px';
                if (self._brushSizeInput) self._brushSizeInput.value = val;
                self._updateBrushSize(val);
            });
        }
    }

    _showFloatingToolbar(show) {
        if (this.floatingToolbar) {
            this.floatingToolbar.hidden = !show;
        }
    }

    /* ── Render Layers Panel ── */
    _renderLayersPanel() {
        var self = this;
        if (!this.layersList) return;
        this.layersList.innerHTML = '';

        if (this._layers.length === 0) {
            this.layersList.innerHTML = '<div class="dt-layer-empty">' + (this.isAr ? 'لا توجد طبقات' : 'No layers') + '</div>';
            return;
        }

        /* Render in reverse order (top layer first) */
        var reversed = this._layers.slice().reverse();
        reversed.forEach(function(layer) {
            var item = self._createLayerItem(layer);
            self.layersList.appendChild(item);
        });
    }

    /* ── Create a single layer item ── */
    _createLayerItem(layer) {
        var self = this;
        var item = document.createElement('div');
        item.className = 'dt-layer-item' + (layer.id === self._activeLayerId ? ' is-active' : '') + (layer.visible === false ? ' is-hidden' : '');
        item.dataset.layerId = layer.id;

        /* Icon */
        var icon = '';
        if (layer.type === 'fabric') icon = '&#129521;';
        else if (layer.type === 'drawing') icon = '&#9998;';
        else if (layer.type === 'pattern') icon = '&#127912;';
        else icon = '&#128444;';

        /* Thumbnail: get from canvas objects */
        var thumbHtml = '';
        var canvasObj = this._getLayerCanvasObject(layer);
        if (canvasObj && canvasObj._element) {
            thumbHtml = '<img class="dt-layer-thumb" src="' + canvasObj._element.src + '" alt="">';
        } else if (layer.type === 'fabric') {
            thumbHtml = '<div class="dt-layer-thumb" style="background:#eee"></div>';
        } else {
            thumbHtml = '<div class="dt-layer-thumb" style="background:#444"></div>';
        }

        var html = '<div class="dt-layer-main">';
        html += '<span class="dt-layer-icon">' + icon + '</span>';
        html += thumbHtml;
        html += '<span class="dt-layer-name">' + layer.name + '</span>';
        html += '</div>';
        html += '<div class="dt-layer-actions">';

        /* Visibility */
        html += '<button class="dt-layer-btn dt-layer-btn--toggle ' + (layer.visible !== false ? '' : 'is-off') + '" data-action="visibility">&#128065;</button>';

        /* Lock (not for drawing) */
        if (layer.type !== 'drawing') {
            html += '<button class="dt-layer-btn dt-layer-btn--lock ' + (layer.locked ? 'is-locked' : '') + '" data-action="lock">' + (layer.locked ? '&#128274;' : '&#128275;') + '</button>';
        }

        /* Delete */
        html += '<button class="dt-layer-btn dt-layer-btn--delete" data-action="delete">&#128465;</button>';
        html += '</div>';

        item.innerHTML = html;

        /* Bind actions */
        item.querySelectorAll('.dt-layer-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                self._handleLayerAction(this.dataset.action, layer);
            });
        });

        /* Click to select layer */
        item.querySelector('.dt-layer-main').addEventListener('click', function() {
            self._activeLayerId = layer.id;
            self._renderLayersPanel();
            /* Select first object of this layer on canvas */
            var objs = self.canvas.getObjects().filter(function(o) { return o._layerId === layer.id; });
            if (objs.length > 0) {
                self.canvas.setActiveObject(objs[0]);
                self.canvas.renderAll();
            }
        });

        return item;
    }

    /* ── Get canvas object for a layer (for thumbnail) ── */
    _getLayerCanvasObject(layer) {
        if (layer.type === 'drawing') {
            var paths = this.canvas.getObjects().filter(function(o) { return o._layerId === layer.id && o.type === 'path'; });
            return paths.length > 0 ? paths[0] : null;
        }
        return this.canvas.getObjects().find(function(o) { return o._layerId === layer.id; }) || null;
    }

    /* ── Handle layer action ── */
    _handleLayerAction(action, layer) {
        var self = this;

        switch (action) {
            case 'visibility':
                layer.visible = layer.visible === false ? true : false;
                /* Apply to all canvas objects of this layer */
                this.canvas.getObjects().forEach(function(obj) {
                    if (obj._layerId === layer.id) {
                        obj.set('visible', layer.visible);
                    }
                });
                /* For drawing layers, apply to all paths */
                if (layer.type === 'drawing') {
                    this.canvas.getObjects().forEach(function(obj) {
                        if (obj._layerId === layer.id && obj.type === 'path') {
                            obj.set('visible', layer.visible);
                        }
                    });
                }
                this.canvas.renderAll();
                break;

            case 'lock':
                layer.locked = !layer.locked;
                this.canvas.getObjects().forEach(function(obj) {
                    if (obj._layerId === layer.id) {
                        if (layer.locked) {
                            obj.set({ selectable: false, evented: false, hasControls: false, hasBorders: false, _locked: true });
                        } else {
                            obj.set({ selectable: true, evented: true, hasControls: true, hasBorders: true, _locked: false });
                        }
                    }
                });
                this.canvas.renderAll();
                break;

            case 'delete':
                /* Remove all canvas objects of this layer */
                var toRemove = this.canvas.getObjects().filter(function(o) { return o._layerId === layer.id; });
                toRemove.forEach(function(o) { self.canvas.remove(o); });
                /* Remove layer entry */
                this._layers = this._layers.filter(function(l) { return l.id !== layer.id; });
                if (this._activeLayerId === layer.id) {
                    this._activeLayerId = this._layers.length > 0 ? this._layers[this._layers.length - 1].id : null;
                }
                this.canvas.discardActiveObject();
                this.canvas.renderAll();
                this._updateSaveBtn();
                break;
        }

        this._renderLayersPanel();
        this._scheduleAutoSave();
    }

    /* ── Assign object to active layer ── */
    _assignToActiveLayer(obj) {
        if (this._activeLayerId) {
            obj._layerId = this._activeLayerId;
        }
    }
}
/* ── Boot ───────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('design-canvas')) {
        DesignEngine.init();
    }
});
