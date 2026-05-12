# توثيق: الصفحات الداخلية + لوحة الأدمن + GitHub

## ملخص

هذا الملف يوثق تنفيذ مرحلة كاملة من المشروع تشمل:
- تحويل صفحتي "وليام موريس" و"الأقمشة الصديقة للبيئة" إلى صفحات مدفوعة بقاعدة البيانات.
- دمج محرر Summernote في لوحة الأدمن مع دعم `anchor_id` للجدول المتحرك (TOC).
- رفع المشروع إلى GitHub مع الأصول المُجمَّعة.

---

## 1. بنية قاعدة البيانات

### نموذج `EducationalPage`
**ملف:** `app/Models/EducationalPage.php`

| حقل | النوع | الوصف |
|-----|-------|--------|
| `slug` | string | معرف الصفحة (`morris`, `fabrics`, `extra-weft`) |
| `title_ar` | string | العنوان بالعربية |
| `title_en` | string | العنوان بالإنجليزية |
| `intro_ar` | text | المقدمة بالعربية |
| `intro_en` | text | المقدمة بالإنجليزية |
| `sections` | JSON | مصفوفة أقسام المحتوى |
| `hero_image` | string | مسار صورة الغلاف (nullable) |

### هيكل عنصر `sections`
```json
{
  "anchor_id": "biography",
  "title_ar": "السيرة الذاتية",
  "title_en": "Biography",
  "body_ar": "<p>HTML content in Arabic...</p>",
  "body_en": "<p>HTML content in English...</p>",
  "image_url": null
}
```

---

## 2. البذر (Seeder)

**ملف:** `database/seeders/EducationalPageSeeder.php`

يُستخدم `updateOrCreate` لكل slug حتى يمكن إعادة تشغيله دون تكرار:

```bash
php artisan db:seed --class=EducationalPageSeeder
```

الصفحات المُبذرة:
- `morris` — وليام موريس (8 أقسام بمحتوى HTML غني)
- `fabrics` — الأقمشة الصديقة للبيئة (5 أقسام بجداول وبطاقات)
- `extra-weft` — النقشة الزائدة (3 أقسام أساسية)

---

## 3. المتحكم (Controller)

**ملف:** `app/Http/Controllers/PageController.php`

```php
public function morris()
{
    $this->trackPageVisit('morris');
    $page = EducationalPage::where('slug', 'morris')->firstOrFail();
    return view('pages.morris', compact('page'));
}

public function fabrics()
{
    $this->trackPageVisit('fabrics');
    $page = EducationalPage::where('slug', 'fabrics')->firstOrFail();
    return view('pages.fabrics', compact('page'));
}
```

---

## 4. صفحات Blade

### الصفحتان الداخليتان

**الملفات:**
- `resources/views/pages/morris.blade.php`
- `resources/views/pages/fabrics.blade.php`

**الخصائص:**
- صفحات `standalone` كاملة (لا ترث `layouts.app`) بـ `@vite` مباشر.
- `<html lang="ar" dir="rtl">` مع `class="scroll-smooth"`.
- `class="inner-page-bg"` على `<body>` لتطبيق خلفية الصفحة الداخلية.

**مكونات الصفحة:**
1. **Header ثابت** — شعار رونق + مسار التنقل (breadcrumb) + زر العودة.
2. **Mobile Title** — مرئي فقط على الشاشات الصغيرة (`md:hidden`).
3. **Hero Banner** — مخفي على الموبايل (`hidden md:block`) — يعرض `$page->title_ar` و `$page->intro_ar` مع صورة الغلاف.
4. **Table of Contents (TOC)** — شريط جانبي لاصق على الديسكتوب، أفقي قابل للتمرير على الموبايل. يتولد ديناميكياً من `$page->sections[*].anchor_id` و `$page->sections[*].title_ar`.
5. **Article Content** — يتكرر على الأقسام ويُخرج `{!! $sec['body_ar'] !!}`.
6. **Footer** — بسيط مع حقوق الملكية.
7. **Script** — `IntersectionObserver` لتفعيل الرابط النشط في TOC مع scroll hint للموبايل.

**CSS المخصص في `resources/css/app.css`:**
- `.inner-page-bg` — خلفية الصفحات الداخلية
- `.img-placeholder` — حاوية صورة وهمية للأقمشة
- `.article-content p/h3` — تنسيق المقالات
- `.toc-link.active` — الرابط النشط في جدول المحتويات

---

## 5. لوحة الأدمن

### إضافة Summernote

**Admin Layout:** `resources/views/admin/layouts/admin.blade.php`

تم إضافة CDNs مباشرة في الـ `<head>`:
```html
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
```
وقبل `</body>`:
```html
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
```

### نموذج تحرير المحتوى

**ملف:** `resources/views/admin/content/edit.blade.php`

التغييرات:
1. **حقل Anchor ID** — حقل نصي جديد `sections[N][anchor_id]` في كل قسم.
2. **محررات Summernote** — تحويل حقلي `body_ar` و `body_en` إلى محررات HTML غنية.
3. **التهيئة الديناميكية** — تهيئة Summernote تلقائياً عند إضافة قسم جديد.
4. **تدمير آمن** — يدمر الـ editors قبل حذف القسم من DOM.

### ContentController

**ملف:** `app/Http/Controllers/Admin/ContentController.php`

تم إضافة `anchor_id` إلى مصفوفة الحقظ:
```php
$sections[] = [
    'anchor_id' => $section['anchor_id'] ?? '',
    'title_ar'  => $section['title_ar']  ?? '',
    // ...
];
```

---

## 6. Git & GitHub

### الاستراتيجية
- `vendor/` و `node_modules/` مستبعدان من `.gitignore`
- `public/build/` **مُدرج** في Git (تم حذف السطر من `.gitignore`) حتى يعمل المشروع على الخادم دون الحاجة لتشغيل `npm run build`

### الأوامر المُنفَّذة
```bash
npm run build                       # بناء الأصول
git init
git remote add origin https://github.com/Mohaamaad7/reem.git
git add .
git commit -m "Initial commit: Laravel app with Morris & Fabrics pages, Summernote admin, compiled assets"
git push -u origin master
```

### الرابط
[https://github.com/Mohaamaad7/reem](https://github.com/Mohaamaad7/reem)

---

## 7. الملفات المُعدَّلة (ملخص)

| الملف | نوع التغيير |
|-------|-------------|
| `database/seeders/EducationalPageSeeder.php` | محتوى HTML كامل لـ morris وfabrics |
| `app/Http/Controllers/PageController.php` | تمرير `$page` من DB للـ views |
| `app/Http/Controllers/Admin/ContentController.php` | حفظ `anchor_id` |
| `resources/views/pages/morris.blade.php` | إعادة كتابة كاملة — DB-driven |
| `resources/views/pages/fabrics.blade.php` | إعادة كتابة كاملة — DB-driven |
| `resources/views/admin/layouts/admin.blade.php` | إضافة jQuery + Summernote CDN، تصحيح slug |
| `resources/views/admin/content/edit.blade.php` | إضافة anchor_id + Summernote editors |
| `resources/css/app.css` | inner-page-bg, img-placeholder, article-content, toc-link |
| `.gitignore` | حذف سطر `/public/build` |

---

## 8. كيفية تحديث المحتوى (للأدمن)

1. انتقل إلى `/admin/content/morris` أو `/admin/content/fabrics`
2. عدّل العناوين والمقدمات حسب الحاجة
3. في قسم "الأقسام":
   - **Anchor ID**: مُعرّف فريد بالإنجليزية بدون مسافات (مثل: `biography`, `artworks`) — يُستخدم لجدول المحتويات والتنقل
   - **عنوان القسم**: يظهر في جدول المحتويات وعنوان القسم
   - **محرر المحتوى (Summernote)**: يدعم الصيغة الغنية HTML — يمكنك التبديل لـ "Code View" لتعديل HTML مباشرة
4. انقر "حفظ التغييرات"
