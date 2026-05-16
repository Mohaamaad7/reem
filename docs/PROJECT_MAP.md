# Project Map — Rawnaq (رونق)

> آخر تحديث: 2026-05-16 (Phase 4 — Dark Theme Redesign)

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

### Mini-Design Studio Phase 3 — Layers Panel (2026-05-16)

#### 1. معمارية لوحة الطبقات (Layers Panel UI)
- **الموقع**: شريط جانبي أيمن (`.dt-sidebar-right`) على الديسكتوب
- **الموبايل**: Bottom Sheet مع زر عائم (`.dt-layers-fab`)
- **المصدر**: تقرأ من `canvas.getObjects()` وتُحدث نفسها تلقائياً عبر أحداث `object:added/removed/modified`
- **كل طبقة تحتوي على**:
  - اسم مبسط + أيقونة معبرة (🧵 قماش، ✏️ رسم حر، 🎨 نقشة SVG، 🖼️ عنصر)
  - زر إخفاء/إظهار (👁️) يتحكم في `obj.visible`
  - زر قفل (🔒) يتحكم في `selectable/evented/hasControls/hasBorders`
  - زر حذف (🗑️) لحذف الطبقة
  - أزرار ترتيب (🔼 🔽) عبر `bringForward` / `sendBackwards`

#### 2. تحويل الأقمشة إلى طبقات عادية (Fabric as Layers)
- **تغيير جذري**: توقف عن استخدام `canvas.setBackgroundImage()`
- **البديل**: إضافة القماش كـ `fabric.Image` عادي عبر `canvas.add()` + `sendToBack()`
- **التأمين (Guardrail)**: القماش يُضاف بخصائص:
  ```
  selectable: false, evented: false, hasControls: false, hasBorders: false, _locked: true
  ```
- **النتيجة**: القماش يظهر كطبقة عادية في لوحة الطبقات، لا يمكن تحديده أو تحريكه إلا بعد رفع القفل

#### 3. تجميع خطوط الرسم الحر (Freehand Drawing Grouping)
- كل `fabric.Path` يحمل `_isDrawingPath = true` يتم تجميعه تحت طبقة واحدة باسم "رسم حر"
- عند حذف/إخفاء طبقة "رسم حر"، يتم تنفيذ الإجراء على **جميع** الـ paths دفعة واحدة
- في الواجهة، طبقة واحدة فقط تظهر باسم "رسم حر" مع أيقونة ✏️

#### 4. مزامنة الحالة (Serialization)
- جميع استدعاءات `canvas.toJSON()` تشمل الآن: `_isFabric`, `_fabricName`, `_locked`
- auto-save و undo/redo و workspaces تعمل مع النظام الجديد
- `_loadDesignIntoCanvas()` يعيّن خصائص القفل تلقائياً عند استرجاع تصميم محفوظ

#### الملفات المعدلة:
| الملف | التغيير |
|-------|---------|
| `public/js/canvas-tool.js` | +200 سطر — تحويل fabric إلى layer + نظام الطبقات + تجميع الرسم الحر |
| `resources/views/pages/design-tool.blade.php` | +30 سطر — HTML لوحة الطبقات + Bottom Sheet + زر عائم |
| `resources/css/app.css` | +120 سطر — أنماط `.dt-sidebar-right` + `.dt-layer-item` + Bottom Sheet |

#### كود Deprecated:
- `canvas.setBackgroundImage()` — لم يُعد مستخدماً في `_selectFabric()` و `_restoreBackground()`
- `canvas.backgroundImage` — تم استبداله بكائنات `_isFabric` عادية
- المرجع الوحيد المتبقي لـ `backgroundImage = null` في `_loadDesignIntoCanvas()` هو إجراء أمان لتصاميم قديمة

### Mini-Design Studio Phase 4 — Dark Theme Redesign (2026-05-16)

#### 1. إعادة تصميم الواجهة الكاملة (Dark Theme)
- **الخلفية**: من `#FAFAFA` متدرجة إلى `#1a1a1a` داكنة
- **الكانفاس**: خلفية بيضاء صافية مع ظل واضح
- **شريط الأدوات**: داكن مع أزرار ذهبية عند التفعيل
- **لوحة الطبقات**: داكنة (`#242424`) مع عناصر (`#2a2a2a`)

#### 2. نظام الطبقات اليدوي (Manual Layer Management)
- **إلغاء الإضافة التلقائية**: القماش لا يُضاف تلقائياً بعد الآن
- **زر "إضافة طبقة"**: المستخدم يضغط ويختار النوع:
  - 🧵 طبقة قماش → modal اختيار القماش
  - 🎨 طبقة نقشة → modal اختيار النقشة
  - ✏️ طبقة رسم حر → تفعيل وضع الرسم
- **هيكل الطبقة**: `{ id, name, type, visible, locked }`
- **ربط الكائنات**: كل كائن كانفاس يحمل `_layerId` يشير لطبقته

#### 3. شريط عائم (Floating Toolbar)
- يظهر فوق الكانفاس عند تفعيل وضع الرسم
- يحتوي على: ألوان (أخضر/أحمر/ذهبي) + أيقونة فرشاة + slider حجم

#### 4. Modals للاختيار
- **Fabric Modal**: شبكة الأقمشة المتاحة
- **Pattern Modal**: شبكة النقوش المتاحة
- يُغلقان بالضغط على X أو خارج المحتوى

#### 5. التوافق مع الميزات القديمة
- **Auto-save**: يحفظ `_layers` + `activeLayerId`
- **Workspaces**: يحفظ/يسترجع `_layers` مع كل workspace
- **Undo/Redo**: يعمل عبر `_layerId` في serialization
- **Saved Designs**: يسترجع `_layers` من التصميم المحفوظ
- **Mobile**: يحتفظ بالتبويبات القديمة كـ fallback

#### الملفات المعدلة:
| الملف | التغيير |
|-------|---------|
| `public/js/canvas-tool.js` | إعادة بناء نظام الطبقات (+300 سطر) |
| `resources/views/pages/design-tool.blade.php` | إعادة بناء HTML كاملة |
| `resources/css/app.css` | +300 سطر (dark theme + أنماط جديدة) |

#### كود Deprecated (Phase 4):
- التبويبات (Fabric/Patterns/Adjust) — مخفية على الديسكتوب، تُستخدم فقط في الموبايل
- `_selectFabric()` — على الديسكتوب لا يفعل شيئاً (يُستخدم عبر modal)
- `_addPattern()` — على الديسكتوب يُنشئ طبقة تلقائياً (للتوافق مع الموبايل)

### Mini-Design Studio Phase 4 — Hotfix (2026-05-16)

#### 1. إصلاح انهيار Constructor (Null DOM References)
- **المشكلة**: عند Phase 4 تم حذف عناصر HTML لإعدادات الفرش (`dt-draw-settings`, `dt-brush-size`, `dt-brush-color`, `dt-eraser-size`) والتبويبات (`dt-category-tabs`, `dt-pattern-grid`) من Blade template (الديسكتوب)، لكن الكود ظل يحاول الوصول إليها.
- **السبب الجذري**: 
  1. `this._brushSizeInput.addEventListener(...)` على `null` يوقف Constructor بالكامل.
  2. استخدام `.appendChild()` على حاويات محذوفة مثل `self.categoryTabs` و `self.patternGrid` أثناء جلب البيانات.
- **التأثير**: كل الدوال اللاحقة لم تُستدعى (أزرار لا تعمل)، وتوقف الصفحة عن التحميل بعد جلب البيانات (شاشة بيضاء).
- **الحل**: إضافة null-safety checks (`if (element)`) قبل كل `.addEventListener()`, `.hidden`, و `.appendChild()` على العناصر المحذوفة.
- **تكامل مع Floating Toolbar**: عندما لا توجد عناصر الفرش القديمة، يُقرأ حجم الفرشاة من `ftbSizeSlider` كبديل.

#### 2. إصلاح جلب الأصول (API Routing Fix)
- **المشكلة**: استدعاء `fetch('/api/patterns')` كمسار مطلق يفشل عندما يتم استضافة المشروع في مجلد فرعي (مثل `localhost/reem1/public/`) ويعمل فقط على النطاق المباشر (مثل `reem1.test`).
- **الحل**: 
  - حقن `url('/')` كـ `<meta name="base-url">` في `layouts/app.blade.php`.
  - قراءة الـ `base-url` في `canvas-tool.js` وإضافته قبل روابط الـ API.

#### الملفات المعدلة:
| الملف | التغيير |
|-------|---------|
| `resources/views/layouts/app.blade.php` | إضافة `<meta name="base-url">` لدعم الـ API |
| `public/js/canvas-tool.js` | إصلاح مسارات API بـ `base-url` + حماية شاملة من null reference في `appendChild` |

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
5. **لوحة الطبقات**: يمكن إضافة دعم التجميع (Groups) وتسمية الطبقات المخصصة

---

##色彩的

- Primary: `#8B6914` (ذهبي)
- Secondary: `#2D5A3D` (أخضر غابة)
- Background: `#0F0A05` / `#1E1409`
- Text: `#F5E6C8` (كريمي)

---

*آخر تحديث: 2026-05-16 — Mini-Design Studio Phase 4 — Dark Theme Redesign*