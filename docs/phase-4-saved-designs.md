# Phase 4 - Saved Designs Integration

This document outlines the implementation of the `saved_designs` system, which enables participants to persist and retrieve their design sessions.

## 1. Database Schema
Created `saved_designs` table with the following schema:
- `participant_id`: Foreign key linking to the `participants` table (cascade on delete)
- `fabric_id`: String (nullable)
- `blend_mode`: String (default: 'multiply')
- `opacity`: Decimal (3,2) (default: 0.80)
- `patterns_used`: JSON (nullable)
- `canvas_json`: LongText
- `preview_image`: LongText (base64 image data)
- `timestamps`

## 2. Models
- **SavedDesign Model**: Added fillable fields, cast `patterns_used` to array, and defined `belongsTo(Participant::class)` relationship.
- **Participant Model**: Added `hasMany(SavedDesign::class)` relationship (`savedDesigns()`).

## 3. Controller & Routes
Created `SavedDesignController` handling operations via the `participant.auth` middleware:
- `store()`: Validates request, saves a new design linked to `session('participant_id')`. Returns `{ success: true, id: X }`.
- `index()`: Returns JSON array of all designs belonging to the current participant, ordered by newest first.
- `destroy($id)`: Deletes a specific design, ensuring it belongs to the current participant.

### API Routes added to `routes/web.php`:
```php
Route::post('/designs', [SavedDesignController::class, 'store'])->name('designs.store');
Route::get('/designs', [SavedDesignController::class, 'index'])->name('designs.index');
Route::delete('/designs/{id}', [SavedDesignController::class, 'destroy'])->name('designs.destroy');
```

## 4. Frontend Integration (`canvas-tool.js`)
- The `_save()` method was updated to POST to `/designs`.
- Payload sends: `fabric_id`, `blend_mode`, `opacity`, `patterns_used`, `canvas_json`, and `preview_image`.
- On successful save, the action button states change and the grid reloads.
- Added a new `_loadSavedDesigns()` flow which fetches data from `/designs` on load and updates the gallery UI.
- Implemented `_renderSavedDesigns(designs)` to construct thumbnail grids, including a 'Delete' button.
- Re-loading a saved design state into Fabric.js triggers via clicking the preview thumbnail, invoking `canvas.loadFromJSON()` and updating local UI state to match.

## 5. UI Updates
- Separated the primary save action into two buttons:
  - "Save Design" (حفظ التصميم)
  - "Proceed to Survey" (الانتقال للاستبيان) (Hidden until at least one design is saved)
- Added the **"Saved Designs"** (تصاميمك المحفوظة) gallery layout right above the action buttons, hidden by default but shown dynamically once designs exist.
