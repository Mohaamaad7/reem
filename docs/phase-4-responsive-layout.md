# Phase 4 - Responsive Split-Panel Layout

This document outlines the responsive layout updates implemented for the design tool, shifting from a simple stacked UI to a dynamic two-panel layout suited for both desktop/tablet and mobile.

## CSS Layout Structure
The primary wrapper `.dt-page` now adapts its layout structure based on the device width.

### Tablet and Desktop Layout (`min-width: 768px`)
- **Structure**: A CSS `grid` split down the middle (`1fr 1fr`).
- **Canvas Panel (Left)**: Pinned using `position: sticky` and `height: 100vh`, ensuring the canvas stays vertically centered and static.
- **Controls Panel (Right)**: Handled as an independent scrolling column (`overflow-y: auto`) containing the 4 operational steps.
- **Save Buttons**: The main action group is fixed at the bottom of the left canvas panel, ensuring the canvas preview and saving functionality are persistently visible while users scroll through the options on the right.

### Mobile Layout (`max-width: 767px`)
- **Structure**: Uses a CSS `flex` column.
- **Canvas Panel (Top)**: Pinned to the top using `position: sticky` with a `z-index` of 10 and a fixed height of `45vh`. This gives users a constant, unmoving view of their canvas while designing.
- **Controls Panel (Bottom)**: Takes the remaining viewport space (`55vh`) and utilizes touch-friendly scrolling (`-webkit-overflow-scrolling: touch`) for all the design steps.
- **Save Buttons**: Rendered as the final element within the bottom scrolling controls panel, presenting a natural "finish" to the scrolling selection flow.

## Canvas Engine Resizing Logic
To guarantee that the Fabric.js canvas adapts without distorting patterns or breaking bounds:
- Canvas dimension logic now dynamically calculates width via an integrated `_resizeCanvas()` method attached to the `window.resize` event.
- **Mobile Size Constraint**: Canvas uses `Math.min(window.innerWidth * 0.9, 300)`.
- **Desktop/Tablet Size**: Explicitly scales to `380x380px`.
- Scaling logic iterates through the Fabric `background-image` and every placed instance to adjust their positional coordinates (`left`, `top`) and scaling (`scaleX`, `scaleY`) correspondingly based on the new dimensional scale ratio.

## DOM Changes
- Refactored `design-tool.blade.php` to extract contents from the standard `.container` into structural wrappers (`.dt-canvas-panel` and `.dt-controls-panel`).
- Because the Save and Proceed buttons belong in different architectural locations depending on the breakpoint, two discrete button instances (`dt-action--desktop` and `dt-action--mobile`) are generated in the DOM. Media queries toggle visibility seamlessly.
- `canvas-tool.js` was modified to target these duplicate buttons as `NodeList` collections via `querySelectorAll()` instead of a singular `getElementById()`, attaching event listeners iteratively to maintain functional parity.
