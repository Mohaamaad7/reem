# خطة مشروع: Rawnaq
## تطبيق تنمية مهارات التصميم على الأقمشة المستدامة بتقنية النقشة الزائدة
### Stack: Laravel 11 + MySQL + Vanilla JS + PWA

---

## نظرة عامة

| البند | التفاصيل |
|---|---|
| **اسم المشروع** | Rawnaq (رونق) |
| **النوع** | Progressive Web App (PWA) |
| **Framework** | Laravel 11 |
| **Database** | MySQL |
| **Frontend** | Blade + Vanilla JS + Custom CSS |
| **اللغات** | عربي + إنجليزي (RTL/LTR) |
| **الهدف** | بحث ماجستير — قياس أثر تطبيق تعليمي على مهارات تصميم الأقمشة |

---

## هيكل المشروع (Laravel Structure)

```
rawnaq/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── ParticipantAuthController.php
│   │   │   │   └── AdminAuthController.php
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ParticipantController.php
│   │   │   │   └── ResponseController.php
│   │   │   ├── PageController.php       # الصفحات التعليمية
│   │   │   ├── DesignToolController.php
│   │   │   └── SurveyController.php
│   │   ├── Middleware/
│   │   │   ├── ParticipantAuth.php      # حماية صفحات المشارك
│   │   │   └── AdminAuth.php            # حماية لوحة التحكم
│   │   └── Requests/
│   │       ├── StoreSurveyRequest.php
│   │       └── StoreParticipantRequest.php
│   │
│   ├── Models/
│   │   ├── Participant.php
│   │   ├── Admin.php
│   │   ├── SurveyResponse.php
│   │   └── UsageSession.php
│   │
│   └── Services/
│       └── GoogleSheetsService.php      # مزامنة Google Sheets
│
├── database/
│   ├── migrations/
│   │   ├── create_admins_table.php
│   │   ├── create_participants_table.php
│   │   ├── create_survey_responses_table.php
│   │   └── create_usage_sessions_table.php
│   └── seeders/
│       └── AdminSeeder.php              # إنشاء Admin الأول
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php            # Layout الرئيسي للمشارك
│   │   │   └── admin.blade.php          # Layout لوحة التحكم
│   │   ├── auth/
│   │   │   ├── login.blade.php          # شاشة إدخال الكود
│   │   │   └── admin-login.blade.php
│   │   ├── pages/
│   │   │   ├── morris.blade.php
│   │   │   ├── fabrics.blade.php
│   │   │   ├── technique.blade.php
│   │   │   ├── design-tool.blade.php
│   │   │   └── survey.blade.php
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── participants/
│   │   │   │   ├── index.blade.php
│   │   │   │   └── create.blade.php
│   │   │   └── responses/
│   │   │       └── index.blade.php
│   │   └── components/
│   │       ├── star-rating.blade.php
│   │       ├── progress-bar.blade.php
│   │       └── language-switcher.blade.php
│   │
│   ├── css/
│   │   ├── app.css                      # الستايل الرئيسي
│   │   ├── rtl.css
│   │   └── animations.css
│   │
│   └── js/
│       ├── app.js
│       ├── lang.js
│       ├── canvas-tool.js
│       └── survey.js
│
├── public/
│   ├── manifest.json                    # PWA Manifest
│   ├── sw.js                            # Service Worker
│   ├── images/
│   │   ├── fabrics/                     # 6 صور أقمشة
│   │   ├── patterns/                    # 10 نقشات SVG
│   │   ├── morris-gallery/              # أعمال وليام موريس
│   │   ├── weaving/                     # رسوم تقنية النسيج
│   │   └── icons/                       # PWA icons
│   └── fonts/
│       ├── Amiri-Regular.woff2
│       ├── Amiri-Bold.woff2
│       └── Playfair-Display.woff2
│
├── lang/
│   ├── ar.json                          # النصوص العربية
│   └── en.json                          # النصوص الإنجليزية
│
├── routes/
│   ├── web.php                          # كل الـ routes
│   └── api.php                          # API routes (فارغ تقريباً)
│
└── config/
    └── sheets.php                       # إعدادات Google Sheets
```

---

## قاعدة البيانات — Migrations

### Migration 1: admins
```php
Schema::create('admins', function (Blueprint $table) {
    $table->id();
    $table->string('username', 50)->unique();
    $table->string('password');
    $table->timestamps();
});
```

### Migration 2: participants
```php
Schema::create('participants', function (Blueprint $table) {
    $table->id();
    $table->string('code', 10)->unique();        // كود الدخول (4 أرقام)
    $table->string('name', 100);
    $table->enum('status', ['pending', 'in_progress', 'completed'])
          ->default('pending');
    $table->timestamp('started_at')->nullable();
    $table->timestamp('completed_at')->nullable();
    $table->timestamps();
});
```

### Migration 3: survey_responses
```php
Schema::create('survey_responses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('participant_id')->constrained()->onDelete('cascade');
    $table->string('participant_code', 10);
    $table->string('participant_name', 100);

    // أداة التصميم
    $table->string('fabric_chosen', 50)->nullable();
    $table->string('pattern_chosen', 50)->nullable();
    $table->tinyInteger('tool_ease_rating')->nullable();        // 1-5
    $table->tinyInteger('tool_visual_rating')->nullable();      // 1-5

    // المحتوى التعليمي
    $table->tinyInteger('morris_knowledge_before')->nullable(); // 1-5
    $table->tinyInteger('morris_knowledge_after')->nullable();  // 1-5
    $table->tinyInteger('technique_clarity')->nullable();       // 1-5
    $table->tinyInteger('eco_fabric_awareness')->nullable();    // 1-5

    // التقييم العام
    $table->tinyInteger('app_overall_rating')->nullable();      // 1-5
    $table->tinyInteger('app_usefulness')->nullable();          // 1-5
    $table->tinyInteger('would_recommend')->nullable();         // 1-5

    // أسئلة مفتوحة
    $table->text('most_liked')->nullable();
    $table->text('improvement_suggestions')->nullable();
    $table->text('design_ideas')->nullable();

    // metadata
    $table->enum('language_used', ['ar', 'en'])->default('ar');
    $table->string('device_type', 50)->nullable();
    $table->integer('time_spent_seconds')->nullable();
    $table->boolean('synced_to_sheets')->default(false);
    $table->string('sheets_row_id', 50)->nullable();
    $table->timestamps();
});
```

### Migration 4: usage_sessions
```php
Schema::create('usage_sessions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('participant_id')->constrained()->onDelete('cascade');
    $table->json('pages_visited')->nullable();
    $table->boolean('design_tool_used')->default(false);
    $table->boolean('survey_completed')->default(false);
    $table->timestamps();
});
```

---

## Models

### Participant.php
```php
class Participant extends Model
{
    protected $fillable = ['code', 'name', 'status', 'started_at', 'completed_at'];
    protected $casts = ['started_at' => 'datetime', 'completed_at' => 'datetime'];

    public function surveyResponse() { return $this->hasOne(SurveyResponse::class); }
    public function usageSession()   { return $this->hasOne(UsageSession::class); }

    // توليد كود عشوائي غير مكرر
    public static function generateUniqueCode(): string
    {
        do {
            $code = str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('code', $code)->exists());
        return $code;
    }
}
```

### SurveyResponse.php
```php
class SurveyResponse extends Model
{
    protected $fillable = [
        'participant_id', 'participant_code', 'participant_name',
        'fabric_chosen', 'pattern_chosen',
        'tool_ease_rating', 'tool_visual_rating',
        'morris_knowledge_before', 'morris_knowledge_after',
        'technique_clarity', 'eco_fabric_awareness',
        'app_overall_rating', 'app_usefulness', 'would_recommend',
        'most_liked', 'improvement_suggestions', 'design_ideas',
        'language_used', 'device_type', 'time_spent_seconds',
    ];

    public function participant() { return $this->belongsTo(Participant::class); }
}
```

---

## Routes (routes/web.php)

```php
<?php
use App\Http\Controllers\Auth\ParticipantAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\ResponseController;

// ==========================================
// شاشة الدخول (عامة)
// ==========================================
Route::get('/', [ParticipantAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [ParticipantAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [ParticipantAuthController::class, 'logout'])->name('logout');

// ==========================================
// صفحات المشارك (محمية بـ ParticipantAuth)
// ==========================================
Route::middleware('participant.auth')->group(function () {
    Route::get('/morris',      [PageController::class, 'morris'])->name('morris');
    Route::get('/fabrics',     [PageController::class, 'fabrics'])->name('fabrics');
    Route::get('/technique',   [PageController::class, 'technique'])->name('technique');
    Route::get('/design-tool', [PageController::class, 'designTool'])->name('design-tool');
    Route::get('/survey',      [SurveyController::class, 'show'])->name('survey');
    Route::post('/survey',     [SurveyController::class, 'store'])->name('survey.store');
    Route::get('/thank-you',   [SurveyController::class, 'thankYou'])->name('thank-you');
});

// ==========================================
// لوحة التحكم (محمية بـ AdminAuth)
// ==========================================
Route::get('/admin/login',  [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout',[AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware('admin.auth')->name('admin.')->group(function () {
    Route::get('/',                       [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('participants',        ParticipantController::class)->only(['index', 'store', 'destroy']);
    Route::get('responses',               [ResponseController::class, 'index'])->name('responses.index');
    Route::get('responses/export',        [ResponseController::class, 'export'])->name('responses.export');
});
```

---

## Middleware

### ParticipantAuth.php
```php
public function handle(Request $request, Closure $next): Response
{
    if (!session()->has('participant_id')) {
        return redirect()->route('login')
               ->with('error', 'يرجى إدخال كود المشاركة أولاً');
    }

    // منع المشارك الذي أكمل من إعادة التجربة
    $participant = Participant::find(session('participant_id'));
    if ($participant?->status === 'completed' && !$request->is('thank-you')) {
        return redirect()->route('thank-you');
    }

    return $next($request);
}
```

### AdminAuth.php
```php
public function handle(Request $request, Closure $next): Response
{
    if (!session()->has('admin_logged_in')) {
        return redirect()->route('admin.login');
    }
    return $next($request);
}
```

---

## Controllers

### ParticipantAuthController.php
```php
// showLogin() → يعرض view('auth.login')

// login(Request $request):
//   validate: code required
//   $participant = Participant::where('code', $request->code)->first()
//   إذا مش موجود → back()->with('error', 'كود غير صحيح')
//   إذا completed → back()->with('error', 'تم إكمال التجربة مسبقاً')
//   يحفظ في session: participant_id, participant_name, participant_code
//   يحدث: status → in_progress, started_at → now()
//   ينشئ UsageSession للمشارك
//   redirect → route('morris')

// logout():
//   session()->forget(['participant_id', 'participant_name', 'participant_code'])
//   redirect → route('login')
```

### Admin/ParticipantController.php
```php
// index(): عرض كل المشاركين مع إحصائياتهم

// store(StoreParticipantRequest $request):
//   $code = Participant::generateUniqueCode()
//   Participant::create(['name' => $request->name, 'code' => $code])
//   return back()->with(['success' => true, 'generated_code' => $code])
//   // الـ view هيعرض الكود في modal مع زر Copy

// destroy(Participant $participant):
//   $participant->delete()
//   return back()->with('success', 'تم الحذف')
```

### SurveyController.php
```php
// show():
//   requireParticipantAuth (via middleware)
//   return view('pages.survey')

// store(StoreSurveyRequest $request):
//   $participant = Participant::find(session('participant_id'))
//   SurveyResponse::create([
//       'participant_id'   => $participant->id,
//       'participant_code' => $participant->code,
//       'participant_name' => $participant->name,
//       ...$request->validated(),
//       'fabric_chosen'    => session('fabric_chosen'),
//       'pattern_chosen'   => session('pattern_chosen'),
//       'device_type'      => $request->userAgent(),
//       'language_used'    => session('lang', 'ar'),
//   ])
//   $participant->update(['status' => 'completed', 'completed_at' => now()])
//   // مزامنة Google Sheets بشكل async
//   dispatch(new SyncToGoogleSheets($response->id))
//   redirect → route('thank-you')
```

### Admin/ResponseController.php
```php
// export():
//   $responses = SurveyResponse::with('participant')->get()
//   return response()->streamDownload(function() use ($responses) {
//       $out = fopen('php://output', 'w')
//       // headers عربية
//       fputcsv($out, ['الكود', 'الاسم', 'القماش', 'النقشة', ...])
//       foreach ($responses as $r) {
//           fputcsv($out, [$r->participant_code, $r->participant_name, ...])
//       }
//       fclose($out)
//   }, 'rawnaq-responses.csv')
```

---

## Google Sheets Service

```php
// app/Services/GoogleSheetsService.php
// يستخدم google/apiclient
// composer require google/apiclient:^2.0

class GoogleSheetsService
{
    private Google\Service\Sheets $service;
    private string $spreadsheetId;

    public function __construct()
    {
        $client = new Google\Client();
        $client->setAuthConfig(storage_path('app/google-credentials.json'));
        $client->addScope(Google\Service\Sheets::SPREADSHEETS);
        $this->service = new Google\Service\Sheets($client);
        $this->spreadsheetId = config('sheets.spreadsheet_id');
    }

    public function appendResponse(SurveyResponse $response): void
    {
        $values = [[
            $response->id,
            $response->created_at->format('Y-m-d H:i'),
            $response->participant_code,
            $response->participant_name,
            $response->fabric_chosen,
            $response->pattern_chosen,
            $response->tool_ease_rating,
            $response->tool_visual_rating,
            $response->morris_knowledge_before,
            $response->morris_knowledge_after,
            $response->technique_clarity,
            $response->eco_fabric_awareness,
            $response->app_overall_rating,
            $response->app_usefulness,
            $response->would_recommend,
            $response->most_liked,
            $response->improvement_suggestions,
            $response->design_ideas,
            $response->language_used,
            $response->time_spent_seconds,
            $response->device_type,
        ]];

        $body = new Google\Service\Sheets\ValueRange(['values' => $values]);
        $this->service->spreadsheets_values->append(
            $this->spreadsheetId, 'Sheet1!A:U',
            $body, ['valueInputOption' => 'RAW']
        );

        $response->update(['synced_to_sheets' => true]);
    }
}
```

---

## Google Sheets Schema

```
A: ID | B: التاريخ | C: كود المشارك | D: اسم المشارك
E: القماش المختار | F: النقشة المختارة
G: سهولة الأداة (1-5) | H: جودة المعاينة (1-5)
I: معرفة موريس قبل (1-5) | J: معرفة موريس بعد (1-5)
K: وضوح النقشة الزائدة (1-5) | L: الوعي بالأقمشة (1-5)
M: التقييم العام (1-5) | N: مدى الفائدة (1-5) | O: التوصية (1-5)
P: أكثر ما أعجبها | Q: اقتراحات | R: أفكار تصميمية
S: اللغة | T: الوقت (ثانية) | U: نوع الجهاز
```

---

## Design System

```css
/* resources/css/app.css */
:root {
  /* ألوان مستوحاة من وليام موريس والطبيعة */
  --color-primary:        #8B6914;   /* ذهبي داكن */
  --color-primary-light:  #C4962A;
  --color-secondary:      #2D5A3D;   /* أخضر غابة */
  --color-secondary-light:#4A8C5C;
  --color-accent:         #8B2635;   /* أحمر بني */
  --color-bg-dark:        #0F0A05;
  --color-bg-medium:      #1E1409;
  --color-bg-card:        #2A1C0D;
  --color-text-primary:   #F5E6C8;   /* كريمي دافئ */
  --color-text-secondary: #C4A87A;
  --color-text-muted:     #8B7355;
  --color-border:         #3D2B14;

  /* Typography */
  --font-display: 'Playfair Display', 'Amiri', serif;
  --font-body:    'Amiri', 'Georgia', serif;
  --font-ui:      system-ui, sans-serif;

  /* Spacing */
  --space-xs: 4px;  --space-sm: 8px;
  --space-md: 16px; --space-lg: 24px;
  --space-xl: 40px; --space-2xl: 64px;

  /* Shadows */
  --shadow-card: 0 4px 24px rgba(0,0,0,0.4), 0 1px 4px rgba(139,105,20,0.2);
  --shadow-glow: 0 0 40px rgba(139,105,20,0.15);
}

body {
  background-color: var(--color-bg-dark);
  background-image: url('/images/bg-pattern.svg'); /* نقشة موريس خفيفة */
  background-size: 120px;
  font-family: var(--font-body);
  color: var(--color-text-primary);
}
```

---

## المراحل والمهام (للـ Cursor)

---

## المرحلة الأولى: إعداد Laravel والبنية التحتية

### المهمة 1.1 — تثبيت Laravel وإعداد المشروع
```bash
# على السيرفر عبر SSH
composer create-project laravel/laravel rawnaq
cd rawnaq

# إعداد .env
DB_DATABASE=rawnaq
DB_USERNAME=...
DB_PASSWORD=...

# تثبيت مكتبة Google Sheets
composer require google/apiclient:^2.0

# إنشاء قاعدة البيانات
mysql -u root -p -e "CREATE DATABASE rawnaq CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### المهمة 1.2 — Migrations و Models
```
أنشئ الـ migrations الأربعة بالترتيب:
1. create_admins_table
2. create_participants_table
3. create_survey_responses_table
4. create_usage_sessions_table

بالتفاصيل الموضحة في قسم "قاعدة البيانات" أعلاه.

أنشئ الـ Models الأربعة:
- Participant (مع generateUniqueCode() static method)
- Admin
- SurveyResponse
- UsageSession

مع العلاقات (relationships) الصحيحة بينهم.

نفّذ: php artisan migrate
```

### المهمة 1.3 — AdminSeeder
```php
// database/seeders/AdminSeeder.php
// ينشئ admin واحد:
Admin::create([
    'username' => 'admin',
    'password' => Hash::make('rawnaq2024'),
]);

// نفّذ: php artisan db:seed --class=AdminSeeder
```

### المهمة 1.4 — Middleware
```
أنشئ Middleware:
- php artisan make:middleware ParticipantAuth
- php artisan make:middleware AdminAuth

بالمنطق الموضح في قسم "Middleware" أعلاه.

سجّلهم في bootstrap/app.php:
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'participant.auth' => ParticipantAuth::class,
        'admin.auth'       => AdminAuth::class,
    ]);
})
```

### المهمة 1.5 — Routes
```
أنشئ routes/web.php كما هو موضح في قسم "Routes" أعلاه بالكامل.
```

### المهمة 1.6 — PWA (manifest + service worker)
```
public/manifest.json:
{
  "name": "Rawnaq - رونق",
  "short_name": "Rawnaq",
  "start_url": "/",
  "display": "standalone",
  "background_color": "#1a1208",
  "theme_color": "#8B6914",
  "orientation": "portrait-primary",
  "lang": "ar",
  "dir": "rtl",
  "icons": [
    { "src": "/images/icons/icon-192.png", "sizes": "192x192", "type": "image/png" },
    { "src": "/images/icons/icon-512.png", "sizes": "512x512", "type": "image/png" }
  ]
}

public/sw.js:
- Cache Strategy: Cache First للـ assets، Network First للـ pages
- Pre-cache: CSS, JS, fonts, images/fabrics/*, images/patterns/*
- لا يـ cache مسارات /admin/*
- Background Sync للاستبيان لو أُرسل offline
```

### المهمة 1.7 — نظام اللغة
```
lang/ar.json و lang/en.json
كل نصوص التطبيق بمفاتيح منظمة:
{
  "nav": { "morris": "...", "fabrics": "...", ... },
  "morris": { "title": "...", "subtitle": "...", ... },
  "survey": { "q1": "...", "q2": "...", ... },
  ...
}

resources/js/lang.js:
- دالة t(key) تُرجع النص حسب اللغة الحالية
- تخزين اللغة في localStorage
- عند التبديل: يغير dir وlang على <html> ويحدث كل النصوص بدون reload
- يحفظ اللغة في session عبر fetch('/set-lang') لتُرسل مع الاستبيان
```

---

## المرحلة الثانية: الـ Layout والواجهة الأساسية

### المهمة 2.1 — Design System
```
أنشئ resources/css/app.css بالمتغيرات الموضحة في قسم "Design System" أعلاه.
أنشئ resources/css/animations.css للأنيميشن.
أنشئ resources/css/rtl.css لتعديلات RTL.

خلفية الصفحة: نقشة SVG هندسية خفيفة مستوحاة من موريس في bg-pattern.svg
```

### المهمة 2.2 — Layout الرئيسي (app.blade.php)
```html
<!DOCTYPE html>
<html lang="{{ session('lang', 'ar') }}" dir="{{ session('lang', 'ar') === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#8B6914">
    <link rel="manifest" href="/manifest.json">
    <title>@yield('title') — نقّاوِيف</title>
    <!-- Fonts: Amiri + Playfair Display من Google Fonts -->
    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <!-- Header: لوجو + Navigation + مؤشر التقدم + زر اللغة -->
    @include('components.header')

    <!-- محتوى الصفحة -->
    <main>@yield('content')</main>

    <!-- Footer بسيط -->
    @include('components.footer')

    <!-- PWA Install Banner -->
    <div id="install-banner" class="install-banner hidden">...</div>

    @stack('scripts')
    <script>
        // تسجيل Service Worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js');
        }
    </script>
</body>
</html>
```

### المهمة 2.3 — Header Component
```
Header يحتوي على:
- لوجو "رونق / Rawnaq" بخط Playfair
- Navigation: موريس | الأقمشة | التقنية | أداة التصميم | الاستبيان
- مؤشر تقدم: 5 نقاط تتلوّن حسب الصفحة الحالية
- زر تبديل اللغة (AR | EN)
- اسم المشارك في الزاوية مع زر تسجيل الخروج
- على الجوال: Hamburger menu مع drawer animation
- الـ Header sticky مع backdrop-filter: blur()
```

### المهمة 2.4 — شاشة الدخول (auth/login.blade.php)
```
لا تستخدم app.blade.php layout — تصميم مستقل.

التصميم:
- صفحة كاملة full-screen
- خلفية: نقشة موريس مع overlay داكن متدرج
- في المنتصف: Card مضيء يحتوي على:
  * لوجو SVG للتطبيق
  * اسم "رونق" بخط Playfair الذهبي
  * وصف: "تجربة تصميم الأقمشة المستدامة"
  * Input كبير: "أدخلي كود المشاركة" (inputmode="numeric", maxlength="4")
  * زر "ابدئي التجربة" بلون ذهبي
  * رسالة خطأ تظهر تحت الـ input بدون reload

JavaScript (fetch):
- عند submit: POST لـ /login
- إذا نجح: redirect لـ /morris
- إذا فشل: رسالة خطأ حمراء + shake animation على الـ input
```

---

## المرحلة الثالثة: الصفحات التعليمية

### المهمة 3.1 — صفحة وليام موريس (pages/morris.blade.php)
```
@extends('layouts.app')

الصفحة تحتوي على:

1. Hero Section:
   - صورة كبيرة لأحد أعمال موريس (Acanthus أو Strawberry Thief)
   - عنوان overlay: "وليام موريس — أب فن الحرف والتصميم"
   - سنوات حياته: 1834 — 1896

2. Timeline السيرة الذاتية:
   - CSS Timeline رأسي
   - 5 محطات رئيسية في حياته مع صور صغيرة
   - كل محطة: السنة + الحدث + أثره على التصميم

3. معرض الأعمال:
   - CSS Grid: 2 عمود على الجوال، 4 على الـ tablet
   - 8 أعمال: Acanthus, Strawberry Thief, Willow Bough,
     Bird & Pomegranate, Marigold, Tulip, Honeysuckle, Blackthorn
   - كل بطاقة: صورة + اسم العمل + السنة
   - Lightbox عند الضغط (CSS only بـ :target selector)

4. فلسفته في التصميم (3 cards):
   - الطبيعة مصدر الإلهام
   - الحرفية والجودة
   - الجمال في الحياة اليومية

5. زر التنقل:
   - "التالي: الأقمشة المستدامة ←"
   - يسجّل الصفحة في usage_sessions عبر fetch
```

### المهمة 3.2 — صفحة الأقمشة المستدامة (pages/fabrics.blade.php)
```
الصفحة تحتوي على:

1. Hero مع إحصائية مؤثرة:
   - "صناعة النسيج تستهلك 93 مليار متر مكعب من الماء سنوياً"
   - رسم بياني SVG بسيط للمقارنة

2. الأقمشة الستة (6 cards تفاعلية):
   كل بطاقة تحتوي على:
   - صورة texture القماش
   - الاسم عربي + إنجليزي
   - مميزات بيئية (chips ملونة: عضوي، قابل للتحلل، إلخ)
   - مقياس "سهولة النسيج": 1-5 دوائر ملوّنة
   - عند الضغط: تتوسع البطاقة لتُظهر معلومات إضافية (CSS accordion)

   الأقمشة:
   * قطن عضوي (Organic Cotton)
   * كتان طبيعي (Natural Linen)
   * حرير السلام (Peace Silk)
   * قماش الباميو (Bamboo Fabric)
   * القنب الطبيعي (Hemp)
   * تنسيل (Tencel / Lyocell)

3. جدول مقارنة تفاعلي:
   - زر "قارني بين الأقمشة" يُظهر/يُخفي الجدول
   - معايير: استهلاك الماء | CO2 | قابلية التحلل | سهولة الصباغة

4. زر "التالي: تقنية النقشة الزائدة ←"
```

### المهمة 3.3 — صفحة النقشة الزائدة (pages/technique.blade.php)
```
الصفحة تحتوي على:

1. Hero مع تعريف موجز للنقشة الزائدة (Extra Weft Technique)

2. مخطط SVG يوضح بنية النسيج الأساسية:
   - خيوط السدى (رأسية) بلون واحد
   - خيوط اللحمة (أفقية) بلون ثانٍ
   - الخيط الزائد (Extra Weft) بلون ذهبي مميز

3. الشرح خطوة بخطوة (5 خطوات):
   - كل خطوة تظهر بـ scroll animation (Intersection Observer)
   الخطوات:
   1. إعداد خيوط السدى (الطولية)
   2. إعداد خيوط اللحمة (العرضية)
   3. التشابك الأساسي (Plain Weave)
   4. إضافة الخيط الزائد (Extra Weft)
   5. الإنهاء والكبس

4. محاكاة تفاعلية بالـ Canvas:
   - أنيميشن يُظهر الخيوط تتشابك تدريجياً
   - الخيط الزائد بلون ذهبي يظهر بعد الأساس
   - زر Play / Pause
   - Slider لسرعة الأنيميشن

5. "النقشة الزائدة عند وليام موريس":
   - أمثلة على أعماله المنسوجة التي استخدم فيها التقنية

6. زر "التالي: جربي أداة التصميم ←"
```

---

## المرحلة الرابعة: أداة التصميم التفاعلية

### المهمة 4.1 — صفحة أداة التصميم (pages/design-tool.blade.php)
```
الصفحة مقسمة لـ 3 أقسام رأسية (Tabs على الجوال):

[القسم 1: اختيار القماش]
- Grid 2×3 من صور الأقمشة الستة
- عند الاختيار: border ذهبي + checkmark أيقونة
- اسم القماش يظهر أسفل الـ Grid

[القسم 2: اختيار النقشة]
- Grid scrollable من 10 نقشات SVG
- نفس سلوك الاختيار
- اسم النقشة يظهر

[القسم 3: المعاينة]
- Canvas بأبعاد 350×350px (أو 300×300 على الشاشات الصغيرة)
- زر "طبّقي النقشة" ← يشغّل Canvas blend
- Opacity slider (30%–100%) لكثافة النقشة
- Scale slider (50%–150%) لحجم النقشة
- زر "أعيدي الاختيار"
- زر "التالي: الاستبيان ←" يحفظ الاختيارات في session

مهم: الزر "التالي" لا يعمل إلا إذا:
- تم اختيار قماش
- تم اختيار نقشة
- تم الضغط على "طبّقي النقشة" مرة واحدة على الأقل
```

### المهمة 4.2 — Canvas JavaScript (resources/js/canvas-tool.js)
```javascript
// الـ SVG patterns محفوظة كـ strings جوه الكود مباشرة (لتفادي CORS)
const PATTERNS = {
  'morris-01': `<svg xmlns="http://www.w3.org/2000/svg">...</svg>`, // Acanthus
  'morris-02': `<svg ...>...</svg>`,  // Strawberry Thief
  // ... باقي النقشات
};

class DesignCanvas {
  constructor(canvasEl) {
    this.canvas = canvasEl;
    this.ctx = canvasEl.getContext('2d');
    this.fabricImg = null;
    this.patternImg = null;
    this.opacity = 0.7;
    this.scale = 1.0;
  }

  async loadFabric(fabricPath) {
    this.fabricImg = await this.loadImage(fabricPath);
    this.render();
  }

  async loadPattern(patternKey) {
    const svgString = PATTERNS[patternKey];
    const blob = new Blob([svgString], { type: 'image/svg+xml' });
    const url = URL.createObjectURL(blob);
    this.patternImg = await this.loadImage(url);
    URL.revokeObjectURL(url);
    this.render();
  }

  render() {
    const { ctx, canvas } = this;
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Layer 1: القماش
    if (this.fabricImg) {
      ctx.globalCompositeOperation = 'source-over';
      ctx.globalAlpha = 1;
      ctx.drawImage(this.fabricImg, 0, 0, canvas.width, canvas.height);
    }

    // Layer 2: النقشة بـ multiply blend
    if (this.patternImg) {
      ctx.globalCompositeOperation = 'multiply';
      ctx.globalAlpha = this.opacity;
      const size = canvas.width * this.scale;
      // تكرار النقشة (tile)
      for (let x = 0; x < canvas.width; x += size) {
        for (let y = 0; y < canvas.height; y += size) {
          ctx.drawImage(this.patternImg, x, y, size, size);
        }
      }
      ctx.globalCompositeOperation = 'source-over';
      ctx.globalAlpha = 1;
    }
  }

  loadImage(src) {
    return new Promise((resolve, reject) => {
      const img = new Image();
      img.onload = () => resolve(img);
      img.onerror = reject;
      img.src = src;
    });
  }

  setOpacity(val) { this.opacity = val; this.render(); }
  setScale(val)   { this.scale = val;   this.render(); }
}

// تهيئة الأداة وربطها بالـ UI
const canvas = new DesignCanvas(document.getElementById('design-canvas'));

// حفظ الاختيارات في sessionStorage
function saveChoices(fabric, pattern) {
  sessionStorage.setItem('fabric_chosen', fabric);
  sessionStorage.setItem('pattern_chosen', pattern);
}

// إرسال الاختيارات للـ session عبر fetch قبل الانتقال للاستبيان
document.getElementById('btn-next').addEventListener('click', async () => {
  await fetch('/save-design-choice', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({
      fabric: sessionStorage.getItem('fabric_chosen'),
      pattern: sessionStorage.getItem('pattern_chosen'),
    })
  });
  window.location.href = '/survey';
});
```

---

## المرحلة الخامسة: الاستبيان والحفظ

### المهمة 5.1 — صفحة الاستبيان (pages/survey.blade.php)
```
الاستبيان مقسم لـ 3 أقسام (بدون page reload — JavaScript فقط):

Progress Bar في الأعلى: [●●●○] القسم 2 من 3

[القسم 1: تقييم أداة التصميم]
- ترحيب: "أهلاً {{ session('participant_name') }}!"
- Q1: سهولة استخدام الأداة — Star Rating (1-5)
- Q2: جودة المعاينة البصرية — Star Rating (1-5)

[القسم 2: تقييم المحتوى التعليمي]
- Q3: معرفتي بوليام موريس قبل التطبيق — Star Rating
- Q4: معرفتي بوليام موريس بعد التطبيق — Star Rating
- Q5: وضوح شرح تقنية النقشة الزائدة — Star Rating
- Q6: وعيي بأهمية الأقمشة المستدامة — Star Rating

[القسم 3: التقييم العام]
- Q7: تقييمك العام للتطبيق — Star Rating
- Q8: ما الذي أعجبك أكثر؟ — textarea
- Q9: ما اقتراحاتك للتطوير؟ — textarea
- زر "أرسلي إجاباتك" ← POST لـ /survey

Star Rating Component:
- 5 نجوم تفاعلية بـ CSS + JS
- hover: تتلوّن حتى النجمة المحددة
- click: تثبت الاختيار
- قيمة مخزّنة في hidden input

شاشة الشكر (thank-you.blade.php):
- "شكراً لكِ يا {{ session('participant_name') }}!"
- "مساهمتكِ ستُثري هذا البحث العلمي"
- أيقونة ✓ مع animation
- لا يوجد زر للعودة (المشارك أكمل التجربة)
```

### المهمة 5.2 — SurveyController@store
```php
// StoreSurveyRequest.php validation rules:
'tool_ease_rating'         => 'required|integer|between:1,5',
'tool_visual_rating'       => 'required|integer|between:1,5',
'morris_knowledge_before'  => 'required|integer|between:1,5',
'morris_knowledge_after'   => 'required|integer|between:1,5',
'technique_clarity'        => 'required|integer|between:1,5',
'eco_fabric_awareness'     => 'required|integer|between:1,5',
'app_overall_rating'       => 'required|integer|between:1,5',
'most_liked'               => 'nullable|string|max:1000',
'improvement_suggestions'  => 'nullable|string|max:1000',
'time_spent_seconds'       => 'nullable|integer',

// store() logic:
$participant = Participant::find(session('participant_id'));
$response = SurveyResponse::create([
    'participant_id'   => $participant->id,
    'participant_code' => $participant->code,
    'participant_name' => $participant->name,
    'fabric_chosen'    => session('fabric_chosen'),
    'pattern_chosen'   => session('pattern_chosen'),
    ...$request->validated(),
    'language_used'    => session('lang', 'ar'),
    'device_type'      => substr($request->userAgent(), 0, 50),
]);

$participant->update(['status' => 'completed', 'completed_at' => now()]);

// مزامنة Google Sheets (يمكن استخدام Queue لو متاح)
try {
    app(GoogleSheetsService::class)->appendResponse($response);
} catch (\Exception $e) {
    // الفشل لا يوقف التجربة — البيانات محفوظة في MySQL
    \Log::error('Sheets sync failed: ' . $e->getMessage());
}

return redirect()->route('thank-you');
```

---

## المرحلة السادسة: لوحة التحكم

### المهمة 6.1 — Admin Dashboard
```
admin/dashboard.blade.php:
- إحصائيات سريعة في 4 cards:
  * إجمالي المشاركين
  * أكملوا التجربة
  * في التجربة الآن (in_progress)
  * لم يبدأوا (pending)
- جدول آخر 5 استجابات
- رابط "عرض كل المشاركين" و"عرض كل الاستجابات"
```

### المهمة 6.2 — إدارة المشاركين
```
admin/participants/index.blade.php:
- جدول: # | الكود | الاسم | الحالة | تاريخ البدء | تاريخ الإكمال | حذف
- فورم إضافة مشارك:
  * حقل الاسم فقط
  * عند الإضافة: الكود يُولَّد تلقائياً ويظهر في modal
  * Modal: "كود المشارك: 3742" مع زر Copy to Clipboard
- زر حذف مع confirm()
- فلتر: الكل | أكملوا | لم يكملوا
```

### المهمة 6.3 — عرض وتصدير الاستجابات
```
admin/responses/index.blade.php:
- جدول بكل الاستجابات
- كل صف: الكود | الاسم | التاريخ | متوسط التقييمات | عرض
- زر "تصدير CSV" يُنزّل الملف مباشرة
- إحصائيات: متوسط كل سؤال
```

---

## المرحلة السابعة: التحسينات والإطلاق

### المهمة 7.1 — PWA Install Experience
```javascript
// في resources/js/app.js
let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    document.getElementById('install-banner').classList.remove('hidden');
});

document.getElementById('btn-install').addEventListener('click', () => {
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then(() => {
        document.getElementById('install-banner').classList.add('hidden');
    });
});

// للـ iOS: رسالة توجيهية "اضغطي Share ثم Add to Home Screen"
```

### المهمة 7.2 — Performance
```
- ضغط الصور: WebP format، كل صورة < 150KB
- Lazy loading: loading="lazy" على صور الـ gallery
- تفعيل GZIP في .htaccess أو nginx config
- Cache headers للـ assets (1 سنة)
- php artisan optimize && php artisan view:cache
```

### المهمة 7.3 — .htaccess / Nginx
```apache
# لـ Apache (في public/.htaccess الموجود في Laravel)
# Laravel بيعمله تلقائياً — تأكد فقط من:
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteRule ^index\.php$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
</IfModule>

# GZIP
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/css application/javascript
</IfModule>
```

---

## ملاحظات للـ Cursor عند التنفيذ

1. **لا تستخدم أي CSS framework** — CSS custom بالكامل باستخدام CSS Variables.

2. **لا تستخدم أي JS framework** — Vanilla JS فقط مع Laravel Blade.

3. **لا Vite complexity** — استخدم `@vite` بشكل بسيط أو حتى `<link>` مباشر للـ CSS.

4. **كل النصوص** في lang/ar.json و lang/en.json — لا نص hardcoded في Blade.

5. **الـ SVG patterns** للـ Canvas تكون strings جوه canvas-tool.js مباشرة.

6. **Google credentials** في storage/app/ وليس في public/.

7. **Session driver** = database أو file (مش cookie لأن البيانات حساسة).

8. **CSRF** — تلقائي في Laravel لكل POST، تأكد من إرساله في fetch requests بـ header.

9. **Fonts** — حمّلها locally في public/fonts/ (مش من Google CDN) للـ offline support.

10. **الاستجابة** — Mobile First. Breakpoints: 480px, 768px, 1024px.

---

## ترتيب التنفيذ لـ Cursor

```
Phase 1 — البنية التحتية:
  1.1 تثبيت Laravel + .env
  1.2 Migrations + Models
  1.3 AdminSeeder
  1.4 Middleware
  1.5 Routes
  1.6 PWA manifest + sw.js
  1.7 نظام اللغة

Phase 2 — الواجهة الأساسية:
  2.1 Design System (CSS Variables)
  2.2 app.blade.php layout
  2.3 Header Component
  2.4 شاشة الدخول

Phase 3 — الصفحات التعليمية:
  3.1 صفحة وليام موريس
  3.2 صفحة الأقمشة المستدامة
  3.3 صفحة النقشة الزائدة

Phase 4 — أداة التصميم:
  4.1 design-tool.blade.php
  4.2 canvas-tool.js (مع SVG patterns)

Phase 5 — الاستبيان:
  5.1 survey.blade.php + star rating component
  5.2 SurveyController@store + StoreSurveyRequest
  5.3 GoogleSheetsService
  5.4 thank-you.blade.php

Phase 6 — لوحة التحكم:
  6.1 Admin Dashboard
  6.2 إدارة المشاركين
  6.3 عرض وتصدير الاستجابات

Phase 7 — التحسينات:
  7.1 PWA Install Experience
  7.2 Performance Optimization
  7.3 .htaccess تأكيد
```

---

## Checklist الإطلاق النهائي

**نظام الدخول:**
- [ ] الكود الخاطئ يعطي رسالة خطأ واضحة بدون reload
- [ ] المشارك الذي أكمل لا يقدر يدخل مرة ثانية
- [ ] Admin panel محمي بـ AdminAuth middleware
- [ ] توليد الأكواد عشوائي وغير مكرر

**التطبيق:**
- [ ] كل صفحات المشارك محمية بـ ParticipantAuth middleware
- [ ] تبديل اللغة يعمل على كل الصفحات بدون reload
- [ ] Canvas tool يعمل على iOS و Android Chrome
- [ ] اختيارات القماش والنقشة تُحفظ وتُرسل مع الاستبيان
- [ ] الاستبيان يُحفظ في MySQL مع participant_id صحيح
- [ ] status المشارك يتحدث لـ completed بعد الإرسال
- [ ] المزامنة مع Google Sheets تعمل (أو تفشل بصمت مع log)

**PWA:**
- [ ] Install prompt يظهر على Android Chrome
- [ ] يعمل على iOS Safari
- [ ] Lighthouse PWA score > 90
- [ ] Lighthouse Performance > 80 على الجوال
- [ ] Service Worker لا يـ cache مسارات /admin/*

**الكود:**
- [ ] php artisan optimize مُنفَّذ
- [ ] لا console errors
- [ ] HTTPS مفعّل
- [ ] google-credentials.json في storage/app/ وليس public/
- [ ] APP_DEBUG=false في .env على السيرفر
