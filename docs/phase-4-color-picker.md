# Phase 4 — Color Picker Refactor

> **Date**: 2026-05-01
> **Scope**: Design Tool — Step 3 (Color Selection)
> **Status**: ✅ Complete

---

## 1. What Changed and Why

### Before (Palette System)
The design tool's Step 3 used **3 palette buttons** (Original, Warm, Cool) that applied predefined filter combinations:
- **Original**: No filters (raw black outlines)
- **Warm**: `Sepia` + `Saturation(0.3)`
- **Cool**: `HueRotation(0.44)` + `Saturation(-0.2)`

**Problems**:
- Only 3 fixed color options — no creative freedom
- Sepia/HueRotation produced muddy, unpredictable tints on black-and-white outlines
- No way to match specific brand colors or personal preferences

### After (Color Picker System)
Step 3 now provides:
1. **8 preset color swatches** — curated, culturally appropriate tones
2. **Native `<input type="color">`** — full spectrum custom color selection
3. **`BlendColor` tint filter** — clean, predictable colorization of outline patterns

---

## 2. How BlendColor Tint Works on Outline PNGs

The pattern images are **black outlines on white backgrounds** (PNG format).

### Rendering Pipeline
1. **Canvas blend mode**: Each pattern `fabric.Image` uses `globalCompositeOperation: 'multiply'`
   - White pixels (255,255,255) become transparent against the fabric background
   - Black pixels (0,0,0) remain dark, showing the outline strokes

2. **Color tinting**: The `BlendColor` filter is applied *before* the multiply blend:
   ```javascript
   new fabric.Image.filters.BlendColor({
       color: '#2E5B1E',  // any hex color
       mode: 'tint',
       alpha: 0.7          // 70% tint strength, 30% original
   })
   ```
   - `mode: 'tint'` — mixes the chosen color into the image pixels
   - `alpha: 0.7` — preserves some of the original tonal range for depth
   - Black strokes become tinted (e.g., dark green), white stays white
   - After multiply blend, white disappears and the colored outlines remain

### Result
The dark outlines take on the chosen color while maintaining their line weight and detail. The white areas remain invisible on the fabric background.

---

## 3. The 12 Pattern Files

All files located in `/public/images/patterns/`:

| Pattern ID     | File Name       | Label       |
|----------------|-----------------|-------------|
| `design-01`    | `01.png`        | تصميم 1     |
| `design-02`    | `02.png`        | تصميم 2     |
| `design-03`    | `03.png`        | تصميم 3     |
| `design-04`    | `04.png`        | تصميم 4     |
| `design-05`    | `05.png`        | تصميم 5     |
| `design-06`    | `06.png`        | تصميم 6     |
| `design-07`    | `07.png`        | تصميم 7     |
| `design-08`    | `08.png`        | تصميم 8     |
| `group-01`     | `group-01.png`  | مجموعة 1    |
| `group-02`     | `group-02.png`  | مجموعة 2    |
| `group-03`     | `group-03.png`  | مجموعة 3    |
| `group-04`     | `group-04.png`  | مجموعة 4    |

### Mapping Logic in `AssetCatalog.patternImage()`
```javascript
const map = {
    'design-01': '01', 'design-02': '02', /* ... */ 'design-08': '08',
    'group-01': 'group-01', 'group-02': 'group-02',
    'group-03': 'group-03', 'group-04': 'group-04',
};
return `/images/patterns/${map[pattern.id]}.png`;
```

---

## 4. New State Structure

### Before
```javascript
this.state = { fabricId: null, paletteId: 'original' };
```

### After
```javascript
this.state = { fabricId: null, tintColor: '#2E5B1E' };
```

### Save Payload Changes
```diff
  body: JSON.stringify({
      fabric:    this.state.fabricId,
      patterns:  JSON.stringify(this.canvas.toJSON()),
      preview:   preview,
-     palette:   this.state.paletteId,
+     tintColor: this.state.tintColor,
  })
```

### SessionStorage Changes
```diff
  sessionStorage.setItem('nw_design', JSON.stringify({
      fabricId:  this.state.fabricId,
-     paletteId: this.state.paletteId,
+     tintColor: this.state.tintColor,
      patterns:  patterns,
  }));
```

> [!IMPORTANT]
> If the backend expects a `palette` field, update the server-side controller to accept `tintColor` (hex string) instead.

---

## 5. How to Add More Patterns

Adding a new pattern is a 2-step process:

### Step 1: Add the PNG file
Place the file in `/public/images/patterns/`. It should be:
- Black outlines on **pure white** (#FFFFFF) background
- PNG format with no transparency (multiply blend handles white removal)
- Recommended size: 200×200px or larger

### Step 2: Update `AssetCatalog` in `canvas-tool.js`

```javascript
// Add to the patterns array:
{ id: 'design-09', name: 'تصميم 9' },

// Add to the patternImage() map:
'design-09': '09',
```

That's it. The color picker and tint filter apply automatically.

---

## 6. Preset Color Swatches

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

**Default on init**: `#2E5B1E` (Morris Green) — chosen to match William Morris's signature palette.

---

## 7. Known Limitations & Edge Cases

1. **BlendColor `tint` mode on pure white**: White pixels get slightly tinted but become invisible after the `multiply` blend. No visual issue, but the filter does process all pixels.

2. **Very light tint colors**: If the user picks near-white (#FAFAFA), the outlines become nearly invisible since multiply of light colors on a light fabric background produces minimal contrast. This is by design — the user can always pick a darker shade.

3. **Pattern file sizes**: Some pattern PNGs (e.g., `08.png` at ~3.3MB, `group-04.png` at ~2.9MB) are large. Consider optimizing with tools like TinyPNG for production.

4. **`applyFilters()` performance**: Each color change re-applies filters to ALL objects on canvas. With many pattern instances (10+), this could cause brief lag on low-end mobile devices. The 400×400 canvas size keeps this manageable.

5. **Color input on iOS**: The native `<input type="color">` may render differently on iOS Safari. It opens a color wheel modal which works well but has platform-specific UX.

---

## Files Modified

| File | Change |
|------|--------|
| `public/js/canvas-tool.js` | Full rewrite — new patterns, color picker logic, BlendColor filter |
| `resources/css/app.css` | Replaced palette button CSS with swatch + custom input styles |
| `resources/views/pages/design-tool.blade.php` | Step 3 heading updated |
| `lang/ar.json` | Updated `step3_title`, added `custom_color` |
| `lang/en.json` | Updated `step3_title`, added `custom_color` |
