# Phase 4 Refactor — Fabric.js Canvas Engine

> **Date:** 2026-04-30  
> **Status:** ✅ Complete  
> **Breaking Change:** Yes — replaces the vanilla `<canvas>` 2D approach with Fabric.js 5.3.0

---

## Why the Pivot?

The original Phase 4 implementation used a raw `CanvasRender` class with `ctx.createPattern()` to tile a single pattern across the canvas. While functional, it had critical limitations:

| Problem | Impact |
|---------|--------|
| Single pattern instance only | User couldn't compose multiple overlapping patterns |
| Scale/Rotate via sliders | Non-intuitive, no direct manipulation |
| No touch support | PWA on mobile had no gesture controls |
| Tiled repeat only | No freeform placement |

**Fabric.js** solves all of these by providing an object model where each pattern is an independent, interactive entity on the canvas.

---

## Architecture

```
design-tool.blade.php
  ├── <canvas id="design-canvas">  (Fabric.js managed)
  ├── Delete Button (#dt-delete-btn)
  ├── Step 1: Fabric Grid (background selection)
  ├── Step 2: Pattern Grid (add instances)
  └── Step 3: Color Palettes (filters)

canvas-tool.js
  ├── AssetCatalog (unchanged SVG generators)
  └── DesignEngine (Fabric.js orchestrator)
        ├── _selectFabric()   → canvas.setBackgroundImage()
        ├── _addPattern()     → new fabric.Image at center
        ├── _selectPalette()  → fabric.Image.filters on ALL objects
        ├── _bindDelete()     → canvas.remove(activeObject)
        └── _save()           → POST canvas.toJSON() + toDataURL()
```

---

## Key Implementation Details

### 1. Canvas Initialization
```javascript
const canvas = new fabric.Canvas('design-canvas', {
    width: 400, height: 400,
    enableRetinaScaling: false,
});
```

### 2. Fabric Background (non-interactive)
When a fabric is selected, its SVG data-URI is loaded via `fabric.Image.fromURL` and set as `canvas.backgroundImage`. It's not selectable or movable — just a visual backdrop.

### 3. Pattern Objects (fully interactive)
Each click on a pattern in the grid creates a **new** `fabric.Image` at the canvas center (200×200px). Properties:
- `globalCompositeOperation: 'multiply'` — blends with fabric texture
- `cornerSize: 30`, `touchCornerSize: 40` — large touch targets
- `transparentCorners: false` — solid corner handles for visibility
- Custom `patternId` property — tracks which pattern was placed

Users can place multiple copies of the same pattern. Each is independent.

### 4. Sliders Removed
Scale and rotation are handled natively by Fabric.js bounding-box controls (drag corners to scale, rotation handle to rotate). This is more intuitive and touch-friendly.

### 5. Delete Button
A single "حذف / Delete" button below the canvas:
- Disabled by default
- Enabled on `selection:created` / `selection:updated`
- Disabled on `selection:cleared`
- Handles both single objects and multi-selection (`activeSelection`)

### 6. Color Palettes via `fabric.Image.filters`
| Palette | Filters Applied |
|---------|----------------|
| Original | `[]` (clear all) |
| Warm | `[Sepia(), Saturation({saturation: 0.3})]` |
| Cool | `[HueRotation({rotation: 0.44}), Saturation({saturation: -0.2})]` |

**Critical:** After setting `obj.filters`, we call `obj.applyFilters()` then `canvas.requestRenderAll()`.

### 7. Save Flow
```
POST /save-design-choice
{
    fabric:   "organic_cotton",
    patterns: canvas.toJSON(),       // full Fabric.js state
    preview:  canvas.toDataURL(),    // PNG base64
    palette:  "warm"
}
```
Server stores `fabric_chosen` and `pattern_chosen` (first pattern ID) in session. Then the client redirects to `/survey`.

### 8. Save Button Logic
Disabled until `state.fabricId` is set AND at least one pattern object exists on canvas.

---

## Files Changed

| File | Action |
|------|--------|
| `resources/views/pages/design-tool.blade.php` | Restructured: Fabric.js CDN, removed sliders (Step 3), added delete button, renumbered to 3 steps |
| `public/js/canvas-tool.js` | Complete rewrite using Fabric.js DesignEngine |
| `resources/css/app.css` | Replaced slider styles with delete button + hint styles |
| `app/Http/Controllers/SurveyController.php` | Updated `saveDesignChoice()` to accept new payload |
| `lang/ar.json` | Removed slider keys, added delete/hint keys |
| `lang/en.json` | Same as above |
| `docs/phase-4-fabricjs-refactor.md` | This file |

---

## Asset Replacement Guide

The `AssetCatalog` SVG generators remain unchanged. To replace with real images:
1. Place fabric images in `public/images/fabrics/` (e.g., `organic_cotton.jpg`)
2. Place pattern images in `public/images/patterns/` (e.g., `acanthus.png` — use transparent PNGs)
3. Update `AssetCatalog.fabricImage()` to return the URL instead of data-URI
4. Update `AssetCatalog.patternImage()` similarly
5. Ensure `crossOrigin: 'anonymous'` on all `fromURL` calls

---

## Mobile Touch Support

Fabric.js 5.3.0 has built-in touch event handling. The large corner sizes (`touchCornerSize: 40`) ensure comfortable interaction on mobile devices. Users can:
- **Drag** patterns freely
- **Pinch** to scale (Fabric.js gesture events)
- **Rotate** via the rotation handle
- **Multi-select** by tapping multiple objects
