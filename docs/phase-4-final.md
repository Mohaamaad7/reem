# Phase 4 Final — Interactive Design Tool (Fabric+Pattern Composition)

> **Date:** 2026-05-05
> **Status:** ✅ Complete
> **Breaking Change:** Yes — Replaces the 3-step color-picker system with a 4-step composition system (Fabric, Pattern, Blend Mode, Opacity). Assets are now auto-discovered from the file system.

---

## 1. The 4-Step UI Architecture

The UI is restructured into exactly 4 sequential steps to guide the user:

### Step 1 — اختاري القماش (Choose Fabric)
- Renders a grid of fabric thumbnails fetched from `/api/fabrics`.
- **Action:** Clicking a fabric loads it as `canvas.backgroundImage`.
- **Behavior:** The fabric acts as a static backdrop. It cannot be selected, moved, or resized.

### Step 2 — اختاري التصميم (Choose Pattern)
- Renders a grid of pattern thumbnails fetched from `/api/patterns`.
- **Action:** Clicking a pattern adds a new `fabric.Image` object.
- **Behavior:** Each pattern is placed at the center of the canvas at `0.3` scale. It is fully interactive (selectable, movable, rotatable, scalable). Touch targets are enlarged (`cornerSize: 30`, `touchCornerSize: 40`).

### Step 3 — طريقة التطبيق (Blend Mode)
- Replaces the old color palettes. Provides 4 blend mode options:
  - `multiply` (متنسج / Woven) — Default. Multiplies pattern pixels with fabric.
  - `overlay` (حيوي / Vivid) — Overlays pattern, boosting contrast.
  - `soft-light` (ناعم / Soft) — Softly blends pattern into fabric.
  - `screen` (شفاف / Screen) — Lightens the fabric based on the pattern.
- **Action:** Selecting a mode applies the corresponding `globalCompositeOperation` to **all** pattern objects currently on the canvas.

### Step 4 — الشفافية (Opacity)
- A single `<input type="range">` slider from 30 to 100 (default 80).
- **Action:** Adjusting the slider dynamically changes the `opacity` property (0.3 to 1.0) of **all** pattern objects on the canvas.

---

## 2. Asset Auto-Discovery System

The application no longer hardcodes asset lists or generates SVG placeholders on the fly. It scans the `public/images/` directory.

### API Endpoints
- `GET /api/patterns` → Scans `public/images/patterns/`
- `GET /api/fabrics` → Scans `public/images/fabrics/`

### How it Works
1. Both endpoints are public (no authentication required) and defined in `routes/web.php`.
2. The `PageController@scanAssets` method reads the directories and filters for valid image extensions (`png, jpg, jpeg, webp, svg`).
3. It returns a sorted JSON array: `[{ "id": "filename-without-ext", "url": "/images/..." }]`.
4. The client-side `DesignEngine.init()` fetches both endpoints in parallel using `Promise.all` and populates the `AssetCatalog`.

### Adding New Assets
Simply drop new image files into the corresponding directory. They will appear in the grid automatically.
- **Fabrics:** `public/images/fabrics/` (e.g., `linen.jpg`)
- **Patterns:** `public/images/patterns/` (e.g., `willow.png`)

> **CORS Requirement:** All images are loaded via `fabric.Image.fromURL` with `crossOrigin: 'anonymous'` to prevent canvas tainting, ensuring `toDataURL()` works correctly.

---

## 3. State Object Final Structure

The client-side `state` object has been simplified:

```javascript
state = {
    fabricId:  'filename_without_ext', // null initially
    blendMode: 'multiply',             // Default
    opacity:   0.8                     // Corresponds to slider value 80
}
```
*Note: Patterns are not stored in scalar state variables. The canvas object model inherently tracks all pattern instances.*

---

## 4. Save Payload Structure

When the user clicks the "Save" button, `DesignEngine._save()` posts the following JSON payload to `POST /save-design-choice`:

```json
{
    "fabric": "linen",
    "patterns": "{\"version\":\"5.3.0\",\"objects\":[...]}",
    "preview": "data:image/png;base64,iVBORw0KGgo...",
    "blendMode": "multiply",
    "opacity": 0.8
}
```

The Laravel `SurveyController` saves these values into the session:
- `fabric_chosen`
- `pattern_chosen` (First pattern ID, extracted from JSON)
- `patterns_chosen` (Array of all pattern IDs, extracted from JSON)
- `blend_mode_chosen`
- `opacity_chosen`
- `design_preview`
- `design_canvas`

---

## 5. Deprecations & Removals

The following systems have been completely removed:
- **Color Picker:** The preset swatches and `input type="color"` custom color picker.
- **Tint Filters:** `fabric.Image.filters.BlendColor` logic and `applyFilters()`.
- **State Properties:** `state.tintColor` and `palette`.

---

## 6. Known Limitations

- **Global Blend & Opacity:** Blend modes and opacity settings apply globally to *all* pattern objects on the canvas simultaneously. Individual layer control is not supported in this UI.
- **Missing Directories:** If `public/images/fabrics/` or `public/images/patterns/` do not exist, the API returns an empty array `[]` safely, and the frontend displays a localized "No fabrics/patterns found" message.
