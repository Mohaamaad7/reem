# Admin Panel — Documentation

## 1. Routes & Controllers

All admin routes are prefixed with `/admin` and protected by the `admin.auth` middleware.

| Method   | URI                              | Controller                  | Method         | Route Name             |
|----------|----------------------------------|-----------------------------|----------------|------------------------|
| GET      | /admin/dashboard                 | DashboardController         | index          | admin.dashboard        |
| GET      | /admin/assets/fabrics            | AssetController             | fabricsIndex   | admin.assets.fabrics   |
| GET      | /admin/assets/patterns           | AssetController             | patternsIndex  | admin.assets.patterns  |
| POST     | /admin/assets/upload             | AssetController             | store          | admin.assets.upload    |
| DELETE   | /admin/assets/{type}/{filename}  | AssetController             | destroy        | admin.assets.destroy   |
| GET      | /admin/content/{slug}            | ContentController           | show           | admin.content.show     |
| POST     | /admin/content/{slug}            | ContentController           | update         | admin.content.update   |
| GET      | /admin/participants              | ParticipantController       | index          | admin.participants.index |
| POST     | /admin/participants              | ParticipantController       | store          | admin.participants.store |
| DELETE   | /admin/participants/{id}         | ParticipantController       | destroy        | admin.participants.destroy |
| GET      | /admin/designs                   | DesignController            | index          | admin.designs.index    |
| GET      | /admin/responses                 | ResponseController          | index          | admin.responses.index  |
| GET      | /admin/responses/export          | ResponseController          | export         | admin.responses.export |

---

## 2. Image Processing Pipeline

When an image is uploaded via `POST /admin/assets/upload`, three versions are created:

### Original
- Saved as-is to `public/images/{type}/originals/{name}.{ext}`
- No processing applied

### Working (for canvas)
- Resized to max **900×900px** (maintaining aspect ratio)
- Quality: **85%**
- Format: **WebP**
- Path: `public/images/{type}/working/{name}.webp`

### Thumbnail (for grid displays)
- Resized to **300×300px** using cover/crop (center)
- Quality: **80%**
- Format: **WebP**
- Path: `public/images/{type}/thumbs/{name}.webp`

### API Response

The public API endpoints (`GET /api/patterns`, `GET /api/fabrics`) now return:

```json
{
    "id": "filename",
    "url": "/images/patterns/working/filename.webp",
    "thumb_url": "/images/patterns/thumbs/filename.webp",
    "working_url": "/images/patterns/working/filename.webp"
}
```

Legacy files (in root `public/images/{type}/`) are supported via fallback — all three URLs point to the same root file.

---

## 3. Educational Pages Data Structure

### Database Table: `educational_pages`

| Column     | Type           | Description                                      |
|------------|----------------|--------------------------------------------------|
| id         | bigint (PK)    | Auto-increment                                   |
| slug       | string (unique)| `morris`, `eco-fabrics`, `extra-weft`             |
| title_ar   | string         | Arabic page title                                |
| title_en   | string         | English page title                               |
| intro_ar   | text           | Arabic introduction paragraph                    |
| intro_en   | text           | English introduction paragraph                   |
| sections   | JSON (nullable)| Array of section objects                         |
| hero_image | string (nullable)| Path to hero image                            |
| timestamps | datetime       | created_at, updated_at                           |

### Sections JSON Structure

```json
[
    {
        "title_ar": "عنوان القسم بالعربي",
        "title_en": "Section Title in English",
        "body_ar": "محتوى القسم بالعربي...",
        "body_en": "Section content in English...",
        "image_url": "/images/content/optional-image.jpg"
    }
]
```

### Model: `App\Models\EducationalPage`

- `sections` is cast to `array` automatically.
- Seeded with 3 pages: `morris`, `eco-fabrics`, `extra-weft`.

---

## 4. How to Add New Content Sections

### Via Admin Panel (recommended)
1. Navigate to the content page (e.g., `/admin/content/morris`)
2. Click "إضافة قسم" (Add Section)
3. Fill in the bilingual title, body, and optional image URL
4. Click "حفظ التغييرات" (Save Changes)

### Via Seeder
Add a new entry in `database/seeders/EducationalPageSeeder.php` using `updateOrCreate`.

### Via Tinker
```php
$page = \App\Models\EducationalPage::where('slug', 'morris')->first();
$sections = $page->sections;
$sections[] = [
    'title_ar' => 'عنوان جديد',
    'title_en' => 'New Section',
    'body_ar' => '...',
    'body_en' => '...',
    'image_url' => null,
];
$page->update(['sections' => $sections]);
```

---

## 5. How to Add New Asset Types

Currently, two asset types are supported: `fabrics` and `patterns`.

To add a new type (e.g., `borders`):

1. **Create directories:**
   ```
   public/images/borders/
   public/images/borders/originals/
   public/images/borders/working/
   public/images/borders/thumbs/
   ```

2. **Update `AssetController`:**
   - Add a new index method (e.g., `bordersIndex()`)
   - Update the `store()` validation to accept the new type:
     ```php
     'type' => 'required|in:fabrics,patterns,borders',
     ```
   - Update the `destroy()` method similarly

3. **Add routes** in `routes/web.php`:
   ```php
   Route::get('assets/borders', [AssetController::class, 'bordersIndex'])->name('assets.borders');
   ```

4. **Add sidebar link** in `resources/views/admin/layouts/admin.blade.php`

5. **Add API endpoint** in `PageController` if needed for the public-facing app

---

## Layout & Design

- **Framework:** Tailwind CSS via CDN
- **Fonts:** Inter + Noto Sans Arabic (Google Fonts)
- **Icons:** Lucide via CDN
- **Direction:** RTL (`dir="rtl"`)
- **Brand colors:** Primary `#8B6914` (Morris gold), Secondary `#2E5B1E` (Morris green)
- **Layout:** Fixed sidebar (w-64) + header (h-16) + scrollable content area
