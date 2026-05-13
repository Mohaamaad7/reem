# Project Map — Rawnaq (رونق)

> آخر تحديث: 2026-05-13

---

## نظرة عامة

| البند | التفاصيل |
|-------|----------|
| **اسم المشروع** | Rawnaq (رونق) |
| **النوع** | Progressive Web App (PWA) |
| **Framework** | Laravel 11 + Vanilla JS |
| **اللغات** | عربي + إنجليزي (RTL/LTR) |
| **الهدف** | تطبيق تعليمي لمهارات تصميم الأقمشة |

---

## هيكل المشروع

```
rawnaq/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/ParticipantAuthController.php
│   │   ├── Auth/AdminAuthController.php
│   │   ├── PageController.php
│   │   ├── SurveyController.php
│   │   └── Admin/
│   ├── Models/
│   │   ├── Participant.php
│   │   ├── SurveyResponse.php
│   │   └── EducationalPage.php
│   └── Middleware/
│
├── resources/
│   ├── views/
│   │   ├── layouts/app.blade.php
│   │   ├── pages/
│   │   │   ├── home.blade.php      # Hub/Dashboard
│   │   │   ├── design-tool.blade.php # Mini-Design Studio
│   │   │   ├── morris.blade.php
│   │   │   ├── fabrics.blade.php
│   │   │   └── survey.blade.php
│   │   └── admin/
│   ├── css/app.css
│   └── js/app.js
│
├── public/
│   ├── js/canvas-tool.js          # Design Tool Engine
│   ├── images/
│   └── build/                     # Compiled assets
│
└── docs/                          # التوثيق
```

---

## الوحدات البرمجية (Modules)

### 1. نظام إدارة المستخدمين (Auth)
- **ParticipantAuthController**: تسجيل دخول المشاركين
- **AdminAuthController**: تسجيل دخول الإدارة
- **ParticipantAuth Middleware**: حماية صفحات المشاركين
- **المستخدمون**: كود دخول 4 أرقام

### 2. الصفحات التعليمية (Educational Pages)
- **willam.html / morris.blade.php**: صفحة وليام موريس
- **smartFabrics.html / fabrics.blade.php**: صفحة الأقمشة المستدامة
- **technique.blade.php**: صفحة النقشة الزائدة
- **المحرر**: Summernote في لوحة التحكم

### 3. أداة التصميم (Design Tool)
- **canvas-tool.js**: محرك Canvas (Fabric.js 5.3.0)
- **design-tool.blade.php**: واجهة المستخدم

#### الميزات الحالية:
- ✅ اختيار القماش (6 خامات)
- ✅ اختيار النقشات (SVG + PNG)
- ✅ Blend Modes (multiply, overlay, etc.)
- ✅ Color Picker (SVG semantic coloring)
- ✅ Opacity slider
- ✅ الحفظ في قاعدة البيانات
- ✅ **الحفظ التلقائي (Auto-Save)** ← جديد
- ✅ **مساحات العمل المتعددة (Workspaces)** ← جديد

### 4. الاستبيان (Survey)
- **survey.blade.php**: نموذج التقييم
- **SurveyController**: معالجة النتائج

### 5. لوحة التحكم (Admin)
- إدارة المشاركين
- عرض وتصدير الاستجابات
- تحرير المحتوى التعليمي (Summernote)

---

## التغييرات الأخيرة (2026-05-13)

### Mini-Design Studio Phase 1

#### 1. الحفظ التلقائي (Auto-Save)
- **الآلية**:监听 أحداث Fabric.js
  - `object:modified`
  - `object:added`
  - `object:removed`
  - `object:scaled`
  - `object:rotated`
- **التخزين**: localStorage
- **المفتاح**: `rawnaq_autosave`
- **Debounce**: 500ms

#### 2. مساحات العمل (Workspaces)
- **الحد الأقصى**: 10 مساحات
- **التسمية**: تلقائية + double-click لإعادة التسمية
- **الحذف**: مع تأكيد
- **التخزين**: localStorage (key: `rawnaq_workspaces`)

#### الملفات المعدلة:
| الملف | التغيير |
|-------|---------|
| `public/js/canvas-tool.js` | +350 سطر (AutoSave + Workspaces complete) |
| `resources/views/pages/design-tool.blade.php` | +UI التبويبات (5 أسطر) |
| `resources/css/app.css` | +50 سطر (Workspace tabs styles) |

---

## التقنيات المستخدمة

| التقنية | الإصدار |
|---------|---------|
| Laravel | 11.x |
| Fabric.js | 5.3.0 |
| Tailwind CSS | 4.x |
| Vite | 8.x |
| Summernote | (Admin only) |

---

## المسارات (Routes)

| المسار | الوصف |
|--------|-------|
| `/` | الصفحة الرئيسية (Hub) |
| `/login` | شاشة الدخول |
| `/morris` | صفحة وليام موريس |
| `/fabrics` | صفحة الأقمشة |
| `/technique` | صفحة التقنية |
| `/design-tool` | أداة التصميم |
| `/survey` | الاستبيان |
| `/admin/*` | لوحة التحكم |

---

## ملاحظات للتطوير المستقبلي

1. **مساحات العمل**: حالياً تخزن في localStorage فقط. يمكن إضافة مزامنة مع الخادم لاحقاً.
2. **SVG Patterns**: حالياً 6 أنماط. يمكن إضافة المزيد من `public/images/patterns/`
3. **الأقمشة**: يمكن استبدال الصور placeholder بصور حقيقية
4. **PWA**: يعمل حالياً على Android Chrome. يحتاج تحسين لـ iOS

---

##色彩的

- Primary: `#8B6914` (ذهبي)
- Secondary: `#2D5A3D` (أخضر غابة)
- Background: `#0F0A05` / `#1E1409`
- Text: `#F5E6C8` (كريمي)

---

*آخر تحديث: 2026-05-13 — Mini-Design Studio Phase 1*