# Project Map — Rawnaq (رونق)

> آخر تحديث: 2026-05-13 (Phase 2 — Fixes v2)

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

### Mini-Design Studio Phase 2

#### 1. وضع الرسم الحر (Drawing Mode Toggle)
- **الآلية**: `canvas.isDrawingMode = true/false`
- **التبديل**: زر في شريط الأدوات الأيسر (Select ↔ Draw)
- **الأيقونة**: SVG تتغير حسب الوضع (pointer/pen)

#### 2. محرك الفرش (Brushes Engine)
- **PencilBrush**: قلم ناعم `new fabric.PencilBrush(canvas)`
- **SprayBrush**: بخاخ نقطي `new fabric.SprayBrush(canvas)`
- **Object-Removal Eraser**: ممحاة تحذف الكائنات المرسومة دون المساس بالقماش

#### 3. إعدادات الفرشاة (Brush Settings)
- **حجم الفرشاة**: شريط تمرير (slider) في لوحة الإعدادات
- **لون الفرشاة**: `<input type="color">` للـ Pencil/Spray
- **حجم الممحاة**: شريط تمرير منفصل يظهر عند اختيار Eraser

#### 4. شريط الأدوات (Toolbar Layout)
- **الموقع**: يسار الكانفاس (عمودي), كل أيقونة بسطر
- **العرض**: 52px ديسكتوب / 46px تابلت
- **الموبايل**: يتحول إلى شريط أفقي أعلى الكانفاس (ارتفاع 44px)
- **RTL**: يبقى على اليسار الفيزيائي باستخدام `order` في CSS

#### 5. التكامل مع الحفظ التلقائي
- **`path:created`**: حدث جديد في auto-save لضمان حفظ المسارات
- **`_isDrawingPath`**: خاصية مخصصة لكل Path تُضاف إلى `canvas.toJSON()`
- **تحديث**: جميع استدعاءات `canvas.toJSON()` تشمل `_isDrawingPath`

#### الملفات المعدلة:
| الملف | التغيير |
|-------|---------|
| `public/js/canvas-tool.js` | +160 سطر (Drawing Engine + auto-save integration) |
| `resources/views/pages/design-tool.blade.php` | +60 سطر (HTML toolbar + SVG icons + settings panel) |
| `resources/css/app.css` | +170 سطر (Toolbar + RTL + responsive styles) |

### Mini-Design Studio Phase 2 — Fixes (2026-05-13)

#### 1. مؤشر الفأرة الدائري (Brush Cursor)
- **الآلية**: عنصر `div` منفصل (`position: fixed; pointer-events: none`) يتحرك فوق الكانفاس
- **يتغير القطر**: بناءً على حجم الفرشاة أو الممحاة المختارة
- **الأحداث**: `mouse:move` يحرك الدائرة، `mouse:down` يخفيها أثناء الرسم، `mouse:up` يعيدها

#### 2. إصلاح الممحاة (Eraser Fix)
- **المشكلة**: الممحاة تمسح `_guideFrame` مما يخلق فراغاً يبدو كأنه محو للقماش
- **الحل**: إضافة `erasable: false` إلى الـ Guide Frame
- **النتيجة**: الممحاة تمسح فقط النقوشات والمسارات المرسومة، والقماش (backgroundImage) محمي تلقائياً

#### 3. نظام Undo/Redo
- **الآلية**: `_history[]` مصفوفة JSON snapshots (حد أقصى 50 خطوة)
- **الاختصارات**: `Ctrl+Z` للتراجع، `Ctrl+Shift+Z` للإعادة
- **الأزرار**: ↩ و ↪ في شريط الإجراءات السفلي (floating action bar)
- **Debounce**: 300ms بين كل snapshot
- **حماية**: `_isUndoRedo` flag يمنع حفظ snapshots أثناء التنقل

#### 4. حفظ التصميم والرجوع إليه
- **beforeunload**: حفظ فوري عند إغلاق التبويب
- **Auto-save recovery**: لا يمسح auto-save بعد الاسترجاع (يبقى كنسخة احتياطية)

#### الملفات المعدلة:
| الملف | التغيير |
|-------|---------|
| `public/js/canvas-tool.js` | +100 سطر (Undo/Redo + cursor preview + erasable fix + beforeunload) |
| `resources/views/pages/design-tool.blade.php` | +سطرين (أزرار Undo/Redo في floating bar) |
| `resources/css/app.css` | +15 سطر (`.dt-cursor-preview` + `.dt-fab-btn--icon`) |

### Mini-Design Studio Phase 2 — Fixes v2 (2026-05-13)

#### 1. إصلاح الممحاة نهائياً (Eraser — erasable flag on backgroundImage)
- **المشكلة**: `EraserBrush` في Fabric.js 5.3 كان يمسح `backgroundImage` (القماش) عند الرسم فوقه
- **السبب الجذري**: `backgroundImage` لم يحمل خاصية `erasable: false` رغم أن `_guideFrame` كان يحملها
- **الحل**: إضافة `erasable: false` في موضعين:
  - `_selectFabric()` عند تحميل القماش الجديد
  - `_restoreBackground()` عند إعادة تحميل القماش من autosave/workspace
- **النتيجة**: الممحاة تمسح فقط الكائنات والمسارات المرسومة، القماش محمي تماماً

#### 2. إصلاح Undo — Snapshots خاطئة أثناء التحميل
- **المشكلة**: `loadFromJSON()` يُطلق أحداث `object:added` لكل كائن → كل حدث يُنشئ snapshot في `_history` → عند الضغط Undo يرجع لحالات وسيطة فارغة
- **الحل**: `_isUndoRedo = true` قبل كل `loadFromJSON` في:
  - `_tryRecovery()` — autosave recovery
  - `_tryRecovery()` — workspace recovery
  - `_loadWorkspaceIntoCanvas()` — workspace switch
- **بعد اكتمال التحميل**: `_isUndoRedo = false` ثم `_saveHistorySnapshot()` مرة واحدة كنقطة بداية نظيفة

#### 3. إصلاح تهيئة Undo — Snapshot فارغ مُبكر
- **المشكلة**: `_initUndoRedo()` كان يستدعي `_saveHistorySnapshot()` مباشرة قبل `_tryRecovery()` → snapshot فارغ يُدخل في التاريخ → Undo يرجع لحالة فارغة بدلاً من التوقف
- **الحل**: `_initUndoRedo()` يبدأ بـ `_isUndoRedo = true` بدون snapshot مبكر — `_tryRecovery()` هي التي تزرع أول snapshot صحيح بعد اكتمال تحميل البيانات

#### 4. إعادة ضبط تاريخ Undo عند تبديل الـ Workspace
- **المشكلة**: عند التبديل بين مساحات العمل كان تاريخ Undo يحمل حالات من الـ workspace السابق
- **الحل**: `_loadWorkspaceIntoCanvas()` يُصفّر `_history` و `_historyIndex` بعد تحميل الـ workspace ويبدأ تاريخاً جديداً

#### الملفات المعدلة:
| الملف | التغيير |
|-------|---------|
| `public/js/canvas-tool.js` | +25 سطر جراحية — 4 إصلاحات دقيقة |

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

*آخر تحديث: 2026-05-13 — Mini-Design Studio Phase 2 Fixes v2*