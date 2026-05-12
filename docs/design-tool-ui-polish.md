# Design Tool — UI Polish & Responsive Layout (Session 2)

> **تاريخ التنفيذ:** مايو 2026  
> **الملفات المعدّلة:**  
> - `resources/css/app.css`  
> - `resources/views/layouts/app.blade.php`

---

## 1. المشاكل التي عولجت

| # | المشكلة | السبب الجذري | الحل |
|---|---------|-------------|------|
| 1 | شريط داكن (bg-pattern) يظهر تحت الهيدر | الـ body background-image يظهر في فجوة أعلى workspace | `body:has(.dt-workspace) { background-image: none }` |
| 2 | فجوة مرئية بين الهيدر والمحتوى | `padding-top` على workspace يخلق shelf فارغة مرئية | تغيير إلى `margin-top` يختفي خلف الهيدر الـ fixed |
| 3 | فجوة ضخمة على الموبايل (240px) | media query أخرى تضيف `padding-top` على `.site-main` وتتغلب على `padding:0` | `padding: 0 !important` على `.site-main--dt` |
| 4 | الـ scroll لا يعمل في الـ sidebar | `height: 100%` على block element داخل flex = غير موثوق | إعادة بناء flex chain: `dt-tab-panels → display:flex` + `dt-tab-panel--active → flex:1 min-height:0` |
| 5 | العنوان غير متمركز في الهيدر | الهيدر يستخدم `width: 480px container` يضغط الـ brand | `position:absolute; inset-inline:0; margin-inline:auto` على `.brand` في صفحة DT |
| 6 | خط عربي غير موجود | لا يوجد Google Font مضاف | إضافة **Tajawal** عبر `app.blade.php` |

---

## 2. إصلاح الفجوة بين الهيدر والمحتوى

### السبب التفصيلي

```
app.css ~ line 507:
@media (max-width: 900px) {
    .site-main {
        padding-top: calc(var(--header-height) + 5rem);  /* = 160px */
    }
}
```

هذه الـ rule تأتي **بعد** `.site-main--dt { padding: 0 }` في الملف، فـ CSS cascade يطبّقها ويُلغي الـ `padding: 0`.

المجموع على الموبايل قبل الإصلاح:
```
main padding-top:   160px   (من media query)
workspace margin-top: 80px  (header height)
────────────────────────────
gap مرئي:           240px   ← ظهر في screenshots
```

### الإصلاح

```css
/* app.css line 107 */
.site-main--dt {
    padding: 0 !important;   /* يمنع أي media query من override */
    overflow: hidden;
    background: #FAFAFA;
}
```

---

## 3. بنية الـ Workspace

### المبدأ الأساسي

```
<body>               → background-image: none (في صفحة DT)
  <header>           → position: fixed; height: 80px; z-index: 40
  <main.site-main--dt> → padding: 0 !important; background: #FAFAFA
    <section.dt-workspace> → margin-top: 80px; height: calc(100vh - 80px)
      <div.dt-canvas-area>  → flex: 1
      <aside.dt-sidebar>    → flex-shrink: 0; width: [variable]
```

### لماذا `margin-top` وليس `padding-top`؟

| الخاصية | النتيجة |
|---------|---------|
| `padding-top: 80px` على workspace | ينشئ **shelf مرئية** بمقدار 80px داخل الـ workspace — فجوة فارغة ظاهرة |
| `margin-top: 80px` على workspace | الـ workspace يبدأ من `y=80px` وهي منطقة يغطيها الهيدر الـ fixed — **غير مرئية** |

```css
.dt-workspace {
    display: flex;
    height: calc(100vh - var(--header-height));   /* يملأ بالضبط ما تبقى */
    margin-top: var(--header-height);              /* يختبئ خلف الهيدر */
    overflow: hidden;
    background: #FAFAFA;
}
```

---

## 4. Flex Chain للـ Scroll في Sidebar

### المشكلة القديمة

```css
/* غير موثوق — height:100% على block element */
.dt-tab-panel { display: block; height: 100%; overflow-y: auto; }
```

### الحل الجديد (flex chain كاملة)

```
.dt-sidebar           → display:flex; flex-direction:column; height: 100%
  .dt-tabs            → flex-shrink: 0        (ثابت، لا يتقلص)
  .dt-tab-panels      → flex:1; min-height:0; display:flex; flex-direction:column
    .dt-tab-panel--active → display:flex; flex:1; min-height:0; overflow-y:auto
```

```css
.dt-tab-panels {
    flex: 1;
    min-height: 0;        /* ضروري لإتاحة التقلص في flex */
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.dt-tab-panel--active {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;        /* ضروري — يتيح overflow-y أن يعمل */
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    overscroll-behavior: contain;
}
```

> **القاعدة:** في flex column، كل عنصر يحتاج `min-height: 0` حتى يتمكن من التقلص دون أن يُجبر الـ container على التمدد.

---

## 5. خط Tajawal العربي

### الإضافة في `app.blade.php`

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
```

### الـ CSS Variables المحدّثة

```css
:root {
    --font-arabic: "Tajawal", "Cairo", "Segoe UI", Tahoma, sans-serif;
    --font-body:   "Tajawal", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    --font-ui:     "Tajawal", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}
```

في صفحة DT خصيصاً:
```css
body:has(.dt-workspace) .brand__title    { font-family: var(--font-arabic); letter-spacing: 0.02em; }
body:has(.dt-workspace) .brand__subtitle { font-family: var(--font-arabic); font-size: 0.8rem; }
```

---

## 6. تمركز العنوان في الهيدر

### المشكلة

الهيدر يستخدم `.container` بعرض `480px` مما يجعل الـ brand ينحاز لأحد الجانبين بدل المنتصف.

### الحل

```css
/* تجاهل الـ container على صفحة DT */
body:has(.dt-workspace) .site-header__inner {
    max-width: 100%;
    width: calc(100% - 3rem);
    position: relative;
    justify-content: flex-end;   /* الأزرار في نهاية السطر */
}

/* تمركز الـ brand بالضبط */
body:has(.dt-workspace) .brand {
    position: absolute;
    inset-inline: 0;             /* يمتد من البداية للنهاية */
    margin-inline: auto;         /* توسيط رياضي */
    width: fit-content;
    text-align: center;
    align-items: center;
}
```

---

## 7. جدول Breakpoints الكامل

### العرض (Width-based)

| Media Query | العرض | الـ Sidebar | الاستخدام |
|-------------|-------|------------|----------|
| Default | > 1366px | **400px** | Desktop كبير |
| `1181–1366px` | 1181-1366px | **380px** | iPad Pro 12.9" landscape |
| `1025–1180px` | 1025-1180px | **340px** | iPad Air landscape (1180×820) |
| `901–1024px` | 901-1024px | **300px** | iPad landscape (1024×768) |
| `768–900px` | 768-900px | **260px** | iPad Mini portrait |
| `≤ 767px` | موبايل | `100% عمودي` | كل الموبايلات |

### الارتفاع (Height-based)

```css
@media (max-height: 820px) and (min-width: 768px) {
    /* شاشات قصيرة landscape — تقليل padding لتوفير مساحة */
    .dt-canvas-area { padding-top: 0.75rem; padding-bottom: 3.5rem; }
    .dt-floating-actions { bottom: 0.75rem; }
}
```

### الاتجاه (Orientation-based)

```css
/* Portrait tablets */
@media (min-width: 768px) and (max-width: 1024px) and (orientation: portrait) {
    .dt-canvas-area { justify-content: center; }   /* الكانفاس في المنتصف عمودياً */
}

/* Portrait 768–900px */
@media (min-width: 768px) and (max-width: 900px) and (orientation: portrait) {
    .dt-sidebar { width: 240px; }
}

/* iPad Pro 12.9" portrait */
@media (width: 1024px) and (orientation: portrait) {
    .dt-sidebar { width: 320px; }
}
```

---

## 8. Mobile Breakpoints التفصيلية

### Portrait (≤ 767px)

```css
@media (max-width: 767px) {
    /* عمودي: كانفاس فوق، sidebar تحت */
    .dt-workspace,
    [dir="rtl"] .dt-workspace { flex-direction: column; }

    .dt-canvas-area {
        flex: 0 0 46%;      /* 46% من ارتفاع workspace */
        min-height: 0;       /* لا min-height — flex يتحكم */
        padding: 0.6rem 0.75rem 3.5rem;
        justify-content: center;
    }

    .dt-sidebar {
        flex: 1;             /* الباقي 54% */
        min-height: 0;
        width: 100%;
        height: auto;
        border-top: 1px solid var(--color-border);
    }
}
```

> **لماذا flex بدل vh؟**  
> القيم القديمة: `canvas: 42vh + sidebar: 52vh = 94vh`  
> الـ workspace: `100vh - 80px ≈ 92vh`  
> النتيجة: **overflow وقطع للمحتوى** على كل الهواتف!  
> الحل الجديد: `flex: 0 0 46% + flex: 1 = 100%` دائماً ✓

### Landscape (≤ 767px)

```css
@media (max-width: 767px) and (orientation: landscape) {
    /* جنباً لجنب مثل التابلت */
    .dt-workspace { flex-direction: row; }
    [dir="rtl"] .dt-workspace { flex-direction: row-reverse; }

    .dt-canvas-area { flex: 1; justify-content: center; }
    .dt-sidebar {
        flex: 0 0 190px;
        border-left: 1px solid var(--color-border);
        border-top: none;
    }
}
```

### Small Phones (≤ 480px)

```css
@media (max-width: 480px) {
    .dt-canvas-area { padding: 0.5rem 0.5rem 3.5rem; }
    .dt-canvas-frame { padding: 0.5rem; border-radius: 12px; }
    .dt-tab-btn { padding: 0.8rem 0.2rem 0.7rem; font-size: 0.7rem; }
    .dt-grid--3col { grid-template-columns: repeat(3, 1fr); gap: 6px; }
}
```

### Very Small Phones (≤ 360px)

```css
@media (max-width: 360px) {
    .dt-canvas-area { flex: 0 0 44%; }
    .dt-tab-btn { font-size: 0.65rem; }
    .dt-grid--3col { grid-template-columns: repeat(2, 1fr); }   /* عمودين بدل 3 */
}
```

---

## 9. أجهزة الاختبار المرجعية

| الجهاز | الأبعاد (px) | الـ Breakpoint المطبق |
|--------|-------------|----------------------|
| iPad Pro 12.9" landscape | 1366×1024 | `1181–1366px` → sidebar 380px |
| iPad Air landscape | 1180×820 | `1025–1180px` → sidebar 340px |
| iPad landscape | 1024×768 | `901–1024px` → sidebar 300px |
| iPad Mini portrait | 768×1024 | `768–900px` + portrait → sidebar 260px, centered |
| iPad Air portrait | 820×1180 | `768–900px` + portrait → sidebar 240px, centered |
| iPhone 14 | 390×844 | `≤767px` portrait → column stack |
| iPhone SE | 375×667 | `≤767px` portrait → column stack |
| iPhone Mini | 360×780 | `≤767px` + `≤360px` → 2-col grid |
| iPhone landscape | 844×390 | `≤767px` landscape → row, sidebar 190px |

---

## 10. ملاحظات مهمة للمطور

1. **`body:has(.dt-workspace)`** — يستهدف صفحة Design Tool فقط دون أن يؤثر على باقي الصفحات. يعمل في Chrome 105+، Firefox 121+، Safari 15.4+.

2. **canvas-tool.js `_resizeCanvas()`** — يقرأ `offsetWidth` و`offsetHeight` من `.dt-canvas-area`. أي تغيير في أبعاد هذا العنصر يستدعي التأكد أن الـ canvas يُعيد حساب نفسه.

3. **الـ `!important` على `.site-main--dt`** — ضروري لأن هناك `@media (max-width: 900px) { .site-main { padding-top: 160px } }` يأتي لاحقاً في الملف ويُلغي الـ `padding: 0` بدون الـ `!important`.

4. **RTL Support** — `[dir="rtl"] .dt-workspace { flex-direction: row-reverse }` يعكس الترتيب فيزيائياً: canvas يسار، sidebar يمين في RTL. في الـ landscape mobile: `row-reverse` أيضاً.

5. **Tajawal Font** — يُحمَّل من Google Fonts بـ `display=swap` لتجنب flash. لو الاتصال ضعيف، ستعمل الـ fallbacks: Cairo → Segoe UI → Tahoma.
