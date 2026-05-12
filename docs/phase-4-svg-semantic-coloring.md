# Phase 4 — SVG Semantic Coloring (التلوين الذكي للعناصر)

> **Date**: 2026-05-10  
> **Scope**: Design Tool — SVG path-level coloring replaces raster filter tinting  
> **Status**: ✅ Complete  
> **Depends on**: Fabric.js 5.3.0 CDN (already loaded)

---

## 1. What Changed and Why

### Before (Raster-Only Pipeline)
All pattern files were PNG/WebP. The coloring pipeline was:
1. `removeNearWhiteBackground()` — pixel-level white removal
2. `fabric.Image.fromURL()` — load as raster image
3. `globalCompositeOperation: 'multiply'` — blend with fabric background
4. `BlendColor` tint filter — apply a single color wash to the entire image

**Problems**:
- Only one color per design — no way to color individual elements (e.g., leaves vs. stems)
- Pixel-based filters degrade quality on zoom
- `multiply` blend makes light colors nearly invisible

### After (Dual Pipeline: Raster + SVG Semantic)
The engine now detects the file extension and routes to two distinct pipelines:

| File Type | Pipeline | Coloring Method |
|-----------|----------|-----------------|
| `.png` / `.webp` / `.jpg` | `_addPatternRaster()` | Blend modes + opacity (unchanged) |
| `.svg` | `_addPatternSvg()` | `subTargetCheck` + per-path `fill` coloring |

SVG files with decomposed paths allow users to click on **individual shapes** (e.g., a leaf, a petal, a border stroke) and change their color independently.

---

## 2. Architecture — File Type Branching

### Entry Point: `_addPattern(pattern)`

```
_addPattern(pattern)
│
├── ext === 'svg'?
│   └── YES → _addPatternSvg(pattern, url)
│             ├── fabric.loadSVGFromURL(url, callback)
│             ├── new fabric.Group(objects, { subTargetCheck: true })
│             ├── group._isSvgGroup = true
│             ├── group.patternId = pattern.id
│             ├── No globalCompositeOperation (uses default 'source-over')
│             └── Opacity from state applied normally
│
└── NO → _addPatternRaster(pattern, url)
          ├── removeNearWhiteBackground(url, callback)
          ├── fabric.Image.fromURL(cleanUrl, callback)
          ├── globalCompositeOperation = state.blendMode
          └── Opacity from state applied normally
```

### Key: `subTargetCheck: true`
This Fabric.js property on a `Group` allows click events to propagate to **child objects** inside the group. Without it, clicking anywhere on the group selects the entire group — with it, individual `Path`, `Circle`, `Rect`, etc. elements inside the SVG become independently selectable.

---

## 3. Smart UI Toggle (Step 3)

Step 3 in the UI now contains **two sections** that toggle based on the currently selected object:

| Selected Object | Blend Section | Color Picker Section |
|----------------|---------------|---------------------|
| Raster `fabric.Image` | ✅ Visible | ❌ Hidden |
| SVG Group (`_isSvgGroup`) | ❌ Hidden | ✅ Visible |
| SVG sub-path (inside group) | ❌ Hidden | ✅ Visible |
| Nothing selected | ✅ Visible (default) | ❌ Hidden |

### Implementation
The toggle is driven by three Fabric.js canvas events:
- `selection:created` → check `e.selected[0]`
- `selection:updated` → check `e.selected[0]`  
- `selection:cleared` → reset to default (show blend, hide color)

Method: `_toggleStep3Sections(activeObj)` inspects `activeObj._isSvgGroup` or `activeObj.group._isSvgGroup` (for sub-paths).

### DOM Structure (Desktop)
```html
<div id="dt-step-3">
    <div id="dt-blend-section">        <!-- Blend mode buttons -->
    <div id="dt-color-section">        <!-- Color swatches + <input type="color"> -->
</div>
```

### DOM Structure (Mobile Bottom Sheet 3)
```html
<div id="dt-bottom-sheet-3">
    <div id="dt-blend-section-mobile">  <!-- Blend mode buttons -->
    <div id="dt-color-section-mobile">  <!-- Color swatches + <input type="color"> -->
</div>
```

---

## 4. Color Picker — How It Works

### Preset Swatches (8 colors)
Generated dynamically by `_buildColorPicker()` into both desktop and mobile containers:

| Hex       | Arabic Label    | English Label   |
|-----------|-----------------|-----------------|
| `#8B4513` | بني دافئ        | Warm Brown      |
| `#2E5B1E` | أخضر موريس      | Morris Green    |
| `#1B3A6B` | أزرق كلاسيكي    | Classic Blue    |
| `#8B1A1A` | أحمر عميق       | Deep Red        |
| `#6B4C8B` | بنفسجي          | Purple          |
| `#C17D2A` | ذهبي            | Gold            |
| `#2A6B6B` | تيل             | Teal            |
| `#1A1A1A` | أسود            | Black           |

### Custom Color Input
A native `<input type="color">` allows any color. Desktop and mobile inputs are synced bidirectionally.

### Color Application Logic: `_applyColorToSelection(color)`

#### The `getActiveObject()` Problem
With `subTargetCheck: true`, Fabric.js registers the click on an internal path, but `canvas.getActiveObject()` **still returns the parent Group** — not the clicked sub-path. This means naive code that checks `active.type === 'path'` will never work, because `active` is always the Group.

#### The Fix: Sub-Target Tracking via `mouse:down`
The `mouse:down` event on the canvas provides an `opt.subTargets` array containing the actual internal objects that were clicked. We capture this in `_bindSubTargetTracking()`:

```javascript
// _bindSubTargetTracking — listens to mouse:down on canvas
this.canvas.on('mouse:down', function(opt) {
    if (opt.subTargets && opt.subTargets.length > 0) {
        self._lastSubTarget = opt.subTargets[0]; // ← the actual clicked path
    } else {
        self._lastSubTarget = null;
    }
});
```

Then in `_applyColorToSelection`:

```javascript
var active = canvas.getActiveObject();

// Case 1: User clicked a specific sub-path inside an SVG Group
if (this._lastSubTarget && this._lastSubTarget.group) {
    this._lastSubTarget.set('fill', color);  // ← colors ONLY the clicked path
}

// Case 2: No sub-target (user selected the Group itself, e.g. via bounding box)
else if (active._isSvgGroup && active.type === 'group') {
    active.getObjects().forEach(obj => obj.set('fill', color));  // ← colors ALL paths
}

// Case 3: Raster image selected → color picker does nothing

canvas.requestRenderAll();
```

> **Why `active.set('fill', color)` instead of `active.fill = color`?**  
> Direct property assignment in Fabric.js doesn't always trigger internal invalidation/dirty flags. The `.set()` method ensures the object is marked as needing re-render.

> **Why `_lastSubTarget` instead of re-querying?**  
> There is no Fabric.js API to ask "which sub-object was last clicked" after the fact. The `subTargets` array is only available inside the `mouse:down` event. We must capture it at click time and store it for when the user picks a color.

---

## 5. Blend Mode Bypass for SVG Groups

### `_selectBlendMode(blendMode)`
SVG groups are **skipped** when applying blend modes:

```javascript
this.canvas.getObjects().forEach(function(obj) {
    if (obj._isSvgGroup) return;  // ← Skip SVG groups
    obj.set({ globalCompositeOperation: blendMode.op });
});
```

**Why?** Blend modes like `multiply` work by manipulating pixel compositing — they make sense for raster images overlaid on a fabric texture. But SVG paths use vector `fill` properties for coloring, so blend modes would produce unexpected/muddy results.

### Opacity — NOT Bypassed
Unlike blend modes, the **opacity slider still applies to SVG groups**. `opacity` works perfectly on `fabric.Group` and allows users to soften the design's visibility against the fabric background.

---

## 6. Serialization — toJSON Fix

### The Problem
`canvas.toJSON()` only serializes standard Fabric.js properties. Custom properties like `patternId`, `_isSvgGroup`, and `subTargetCheck` are silently dropped.

Without fixing this:
- Saved designs lose the `_isSvgGroup` flag → blend mode bypass breaks on reload
- `subTargetCheck` is lost → sub-path clicking stops working after load
- `patternId` is lost → pattern tracking breaks

### The Fix
```javascript
// Before:
canvas_json: JSON.stringify(this.canvas.toJSON()),

// After:
canvas_json: JSON.stringify(this.canvas.toJSON(['patternId', '_isSvgGroup', 'subTargetCheck'])),
```

The property names array tells Fabric.js to include these custom properties in the serialized JSON. On `loadFromJSON()`, they are automatically restored onto the deserialized objects.

---

## 7. New DOM Element IDs

### Desktop
| ID | Element | Purpose |
|----|---------|---------|
| `dt-blend-section` | `<div>` | Wrapper for blend mode buttons (toggled) |
| `dt-color-section` | `<div>` | Wrapper for color picker UI (toggled) |
| `dt-color-swatches` | `<div>` | Container for swatch buttons (populated by JS) |
| `dt-color-picker` | `<input type="color">` | Custom color input |

### Mobile
| ID | Element | Purpose |
|----|---------|---------|
| `dt-blend-section-mobile` | `<div>` | Wrapper for blend mode buttons (toggled) |
| `dt-color-section-mobile` | `<div>` | Wrapper for color picker UI (toggled) |
| `dt-color-swatches-mobile` | `<div>` | Container for swatch buttons (populated by JS) |
| `dt-color-picker-mobile` | `<input type="color">` | Custom color input |

---

## 8. New CSS Classes

| Class | Purpose |
|-------|---------|
| `.dt-color-swatches` | Flex row for swatch buttons (wraps, 10px gap) |
| `.dt-color-swatch` | 36×36px circular color button with hover scale effect |
| `.dt-color-custom` | Flex row for custom color label + input |
| `.dt-color-custom__label` | Label text for the custom color input |
| `.dt-color-custom__input` | Styled `<input type="color">` with rounded corners |

---

## 9. New/Modified Methods in `DesignEngine`

| Method | Status | Description |
|--------|--------|-------------|
| `_addPattern(pattern)` | **Modified** | Now branches by file extension |
| `_addPatternSvg(pattern, url)` | **New** | SVG loading via `fabric.loadSVGFromURL` → `fabric.Group` |
| `_addPatternRaster(pattern, url)` | **New** | Extracted existing PNG/WebP flow (unchanged logic) |
| `_buildColorPicker()` | **New** | Generates swatches, binds color input events |
| `_applyColorToSelection(color)` | **New** | Colors `_lastSubTarget` if set, otherwise all group children |
| `_bindSubTargetTracking()` | **New** | `mouse:down` listener captures sub-target + applies highlight |
| `_highlightSubTarget(subTarget)` | **New** | Adds gold stroke highlight to clicked sub-path, clears previous |
| `_clearSubTargetHighlight()` | **New** | Restores original stroke on previously highlighted sub-path |
| `_toggleStep3Sections(activeObj)` | **New** | Shows/hides blend vs. color picker sections |
| `_bindSelection()` | **Modified** | Now calls `_toggleStep3Sections` on selection events |
| `_selectBlendMode(blendMode)` | **Modified** | Skips objects with `_isSvgGroup === true` |
| `_save()` | **Modified** | `toJSON(['patternId', '_isSvgGroup', 'subTargetCheck'])` |

---

## 10. Files Modified

| File | Change |
|------|--------|
| `public/js/canvas-tool.js` | SVG branching, color picker logic, blend bypass, toJSON fix |
| `resources/views/pages/design-tool.blade.php` | Step 3 split into blend/color sections (desktop + mobile) |
| `resources/css/app.css` | Color swatch and custom input styles |
| `docs/phase-4-svg-semantic-coloring.md` | This documentation file |

---

## 11. How to Add SVG Patterns

### Step 1: Prepare the SVG
- Each shape/element must be a separate `<path>`, `<circle>`, `<rect>`, etc.
- **Do not flatten** paths into a single compound path — that defeats sub-targeting
- Recommended: Use Illustrator's "Release Compound Path" or Inkscape's "Break Apart"
- Each element should have a distinct `fill` color (can be any default — users will change it)

### Step 2: Upload the SVG
Place the `.svg` file in `public/images/patterns/working/`. The existing `PageController::scanAssets()` already scans for `.svg` extension.

Optionally add a `.webp` thumbnail in `public/images/patterns/thumbs/` with the same base name for faster grid loading.

### Step 3: Done
The engine automatically:
1. Detects the `.svg` extension from the URL
2. Loads it via `fabric.loadSVGFromURL`
3. Creates a `Group` with `subTargetCheck: true`
4. Shows the color picker UI when the design is selected

---

## 12. UX Fixes — Sub-Target Highlight & Selection Persistence

### Problem 1: No Visual Feedback on Sub-Path Click
When the user clicks a specific path inside the SVG group, the selection border always stays on the entire group. There was no visual indication of *which* sub-path was targeted for coloring.

**Solution: Gold Stroke Highlight**

When `mouse:down` fires with `opt.subTargets[0]`, the engine:
1. Restores the previous sub-target's original `stroke` and `strokeWidth`
2. Saves the new sub-target's current `stroke`/`strokeWidth` as `_origStroke` / `_origStrokeWidth`
3. Applies a gold highlight: `stroke: '#D4AF37'`, `strokeWidth: 2`
4. Calls `canvas.requestRenderAll()`

When selection is cleared or a non-sub-target area is clicked, the highlight is removed and originals restored.

```javascript
_highlightSubTarget(subTarget) {
    // Clear previous highlight
    if (this._lastSubTarget && this._lastSubTarget !== subTarget) {
        this._lastSubTarget.set({
            stroke: this._lastSubTarget._origStroke || null,
            strokeWidth: this._lastSubTarget._origStrokeWidth || 0,
        });
    }
    // Save originals and apply highlight
    subTarget._origStroke = subTarget.stroke || null;
    subTarget._origStrokeWidth = subTarget.strokeWidth || 0;
    subTarget.set({ stroke: '#D4AF37', strokeWidth: 2 });
    this._lastSubTarget = subTarget;
    this.canvas.requestRenderAll();
}
```

### Problem 2: Selection Lost When Clicking Color Picker
The document-level click listener (Part 3) discards the active object whenever the user clicks outside the canvas wrapper. Since the color picker inputs and swatch buttons live in the controls panel (outside the canvas), clicking them would clear the selection — making the color change fail silently.

**Solution: Exclude Color Tool Clicks from Deselection**

The click handler now checks if the click target is inside a color tool container before discarding:

```javascript
document.addEventListener('click', function(e) {
    var wrapper = self.canvas.wrapperEl;
    if (wrapper && !wrapper.contains(e.target)) {
        // ← Don't deselect if user is interacting with color tools
        var isColorTool = e.target.closest &&
            (e.target.closest('.dt-color-section') ||
             e.target.closest('.dt-color-custom') ||
             e.target.closest('.dt-color-swatches'));
        if (isColorTool) return;

        self.canvas.discardActiveObject();
        self.canvas.requestRenderAll();
    }
});
```

This uses `Element.closest()` to walk up the DOM and check if the click target is inside any of the color picker containers. If it is, the function returns early without discarding the selection.

---

## 13. UX Fixes — Swatch Size, Keyboard Delete & Multi-Selection

### Swatch Buttons Made Larger and Square
Color swatches were 36×36px circles — too small to tap comfortably, especially on touch devices. Changed to **52×52px rounded squares** (`border-radius: 10px`) with `min-width`/`min-height` and `flex-shrink: 0` to prevent compression.

### Keyboard `Delete` Key Support
Added a `keydown` listener on `document` that triggers the same delete logic as the delete button when `Delete` is pressed. Skips the event if focus is on an `input`, `textarea`, or `select` to avoid interfering with text editing.

### Multi-Selection of SVG Sub-Paths (Shift / Alt + Click)
Refactored from a single `_lastSubTarget` to an array `_selectedSubTargets[]`.

**Behavior:**
- **Plain click** on a sub-path → clears all previous highlights, selects only the clicked path
- **Shift+click** or **Alt+click** → **adds** the clicked path to the selection (toggle: clicking an already-selected path removes it)
- Choosing a color applies to **all selected sub-paths** simultaneously
- If no sub-paths are selected and a color is picked, the entire SVG group is colored as a whole

**Implementation:**
```javascript
// In mouse:down handler:
var multiSelect = opt.e && (opt.e.shiftKey || opt.e.altKey);
self._highlightSubTarget(opt.subTargets[0], multiSelect);

// _highlightSubTarget(subTarget, addToSelection):
// - addToSelection=true  → push to array (or splice out if already in array = toggle)
// - addToSelection=false → clear all, push only this one
```

---

## 14. Known Limitations

1. **SVG with single compound path**: If the SVG has all shapes merged into one `<path>` element, `subTargetCheck` won't help — there's only one target. The SVG must have decomposed/separate paths.

2. **Color picker on mobile**: The native `<input type="color">` opens a platform-specific color wheel (iOS Safari shows a modal, Android Chrome shows a popup). This works well but looks different per device.

3. **No per-object color memory**: If the user colors individual paths, then deselects and reselects, the color picker doesn't reflect the current fill of the selected path. The input retains its last value. This is acceptable for v1.

4. **`loadFromJSON` and SVG groups**: When loading a saved design, the SVG group is deserialized as a generic `fabric.Group` with the custom properties restored. The `subTargetCheck` flag ensures sub-path clicking works after load.

5. **Mixed raster + SVG on canvas**: Both types can coexist on the same canvas. Blend modes apply only to raster objects; color picker applies only to SVG objects. The UI toggles based on which object is currently selected.
