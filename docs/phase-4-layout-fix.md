# Phase 4 — Layout Fix & Canvas Interaction Improvements

**Date:** 2026-05-09  
**Status:** Complete  
**Files modified:** 4

---

## Overview

Complete overhaul of the Design Tool page layout, canvas sizing, and interaction behavior. All 6 parts implemented as specified.

---

## Files Changed

| File | Change |
|---|---|
| `resources/views/layouts/app.blade.php` | Added conditional `site-main--dt` class on design-tool route |
| `resources/views/pages/design-tool.blade.php` | Restructured layout, added mobile icon buttons + 4 bottom sheet modals |
| `resources/css/app.css` | Rewrote design tool responsive layout, added bottom sheet styles, updated empty state |
| `public/js/canvas-tool.js` | Complete rewrite with all 6 parts |

---

## Part 1 — Layout (CSS Grid)

### Desktop (min-width: 1024px)
- `.dt-page`: `display: grid; grid-template-columns: 1fr 1fr; height: 100vh; overflow: hidden`
- `.dt-canvas-panel`: sticky left panel, flex column, centered, `background: var(--color-surface)`
- `.dt-controls-panel`: right panel, `overflow-y: auto`, `padding: 1.5rem`

### Tablet (768px – 1023px)
- Same 2-column grid but `grid-template-columns: 55% 45%`

### Mobile (max-width: 767px)
- `.dt-page`: `display: flex; flex-direction: column`
- `.dt-canvas-panel`: top 50vh, centered
- `.dt-controls-panel`: bottom 50vh, scrollable
- `.dt-steps` hidden; 4 icon buttons shown instead
- Each button opens a bottom sheet modal

### Site Main Override
- Added `.site-main--dt { padding: 0; }` to remove default header padding on design tool page
- `app.blade.php` conditionally adds this class via `request()->routeIs('design-tool')`

---

## Part 2 — Canvas Square + Responsive Size

`_resizeCanvas()` recalculates on init and on `window.resize`:

```js
// Desktop/Tablet:
size = Math.min(leftPanelWidth * 0.85, leftPanelHeight * 0.85)

// Mobile:
size = Math.min(window.innerWidth * 0.90, window.innerHeight * 0.44)
```

Applied via:
```js
canvas.setWidth(size);
canvas.setHeight(size);
canvas.setDimensions({ width: size, height: size });
canvas.renderAll();
```

Background image and all objects are scaled proportionally.

---

## Part 3 — Deselect When Clicking Outside

Added after canvas initialization:

```js
document.addEventListener('click', function(e) {
    var canvasEl = document.getElementById('design-canvas');
    if (canvasEl && !canvasEl.contains(e.target)) {
        this.canvas.discardActiveObject();
        this.canvas.requestRenderAll();
    }
}.bind(this));
```

---

## Part 4 — Remove Near-White Borders

`removeNearWhiteBackground(imageUrl, callback)` function:
- Loads image into offscreen canvas
- Iterates pixel data; sets alpha to 0 for any pixel where R > 220, G > 220, B > 220
- Returns cleaned data URL via callback
- Falls back to original URL on error

Used in `_addPattern()`:
```js
removeNearWhiteBackground(pattern.url, function(cleanUrl) {
    fabric.Image.fromURL(cleanUrl, function(img) { ... });
});
```

---

## Part 5 — Canvas Empty Placeholder

- Absolutely positioned `<div>` over canvas with `z-index: 2`
- Background: `#1a1a1a` (solid dark, no checkerboard)
- Centered 🎨 icon (48px) + Arabic/English text
- Hidden via `[hidden]` attribute when `fabricId` is set or objects exist on canvas
- CSS: `.dt-preview__empty[hidden] { display: none; }`

---

## Part 6 — Subtle Selection Handles

### Canvas-level:
```js
selectionColor: 'rgba(212, 175, 55, 0.15)',
selectionBorderColor: 'rgba(212, 175, 55, 0.6)',
selectionLineWidth: 1,
```

### Per-object (in `_addPattern`):
```js
borderColor: 'rgba(212, 175, 55, 0.8)',
cornerColor: '#D4AF37',
cornerSize: 24,
touchCornerSize: 36,
transparentCorners: false,
borderScaleFactor: 1,
padding: 4,
```

---

## Mobile Bottom Sheet Modals

4 bottom sheets (`#dt-bottom-sheet-1` through `#dt-bottom-sheet-4`):
- Slide up from bottom with `transform: translateY(100%)` → `translateY(0)`
- Backdrop with blur closes on tap
- ✕ close button
- Drag handle indicator
- Each contains the corresponding step content (fabric grid, pattern grid, blend buttons, opacity slider)
- Mobile opacity slider synced bidirectionally with desktop slider

---

## Verification

```bash
npm run build   # ✓ 6 modules transformed, built in 806ms
```

Test codes available: `1234`, `5678`, `0001`, `0002`, `9999`
