# Light Theme Redesign & Scroll Bug Fix

## Date: 2026-05-11

---

## 1. Light Theme — Visual Identity Flip

### Problem
The current dark-brown theme across the entire page is gloomy and strains the eyes, especially during prolonged design sessions.

### Solution
Flip from dark theme to a light, comfortable theme:

| Element | Before (Dark) | After (Light) |
|---|---|---|
| Page background | `#17130f` (near-black) | `#faf8f4` (warm cream) |
| Card body | `rgba(38,31,25,0.92)` (dark brown) | `rgba(255,252,247,0.95)` (off-white) |
| Primary text | `#f3eadb` (light cream) | `#2d2416` (dark brown) |
| Secondary text | `#d5c3a9` | `#5c4a2e` |
| Muted text | `#a39179` | `#8c7a5e` |
| Borders | `rgba(196,168,122,0.22)` | `rgba(139,105,20,0.2)` |
| Shadows | Heavy dark shadows | Lighter, softer shadows |

### Card Headers — Dark-on-Light Contrast
- `.dt-step__header` gets a dark brown background (`#211b16`) with light text (`#f3eadb`)
- This creates a chic contrast: dark header bar atop a light card body
- The step number circle keeps its gold gradient

---

## 2. Scroll Bug Fix

### Problem
The `.dt-page` container uses `height: calc(100vh - ...)` and `overflow: hidden` at all breakpoints (desktop, tablet, mobile). This locks the page to viewport height and prevents scrolling to:
- Save Design button
- Proceed to Survey button
- Saved Designs gallery

Users must zoom out to 50% to see these elements.

### Root Cause
```css
/* All three breakpoints had: */
.dt-page {
    height: calc(100vh - var(--header-height) - var(--space-sm));
    overflow: hidden;
}
.dt-canvas-panel {
    position: sticky;
    height: 100%;
}
.dt-controls-panel {
    height: 100%;
    overflow-y: auto;
}
```

### Fix
- Remove `height` and `overflow: hidden` from `.dt-page` — let it flow naturally
- Remove `position: sticky` and `height: 100%` from `.dt-canvas-panel`
- Remove `height: 100%` and `overflow-y: auto` from `.dt-controls-panel`
- The page now scrolls naturally like any normal page

---

## 3. Responsive Canvas Size

### Problem
The canvas takes too much vertical space, making it hard to see the full design context.

### Fix
- Canvas gets `max-height: 60vh` on desktop/tablet so it stays within the user's field of view
- The preview wrapper uses `max-width` + `max-height` constraints
- On mobile, canvas height adjusts to `40vh` max

---

## Files Modified

| File | Changes |
|---|---|
| `resources/css/app.css` | CSS variables, body, layout, step cards, header, bottom sheets |
| `docs/light-theme-and-scroll-fix.md` | This document |
