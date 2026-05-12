<?php

use App\Http\Controllers\Auth\ParticipantAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SavedDesignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\ResponseController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DesignController;
use Illuminate\Support\Facades\Route;

// ==========================================
// الصفحة الرئيسية (Dashboard / Hub)
// ==========================================
Route::get('/', [PageController::class, 'home'])->name('home');

// ==========================================
// شاشة الدخول (عامة)
// ==========================================
Route::get('/login', [ParticipantAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [ParticipantAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [ParticipantAuthController::class, 'logout'])->name('logout');

// تبديل اللغة
Route::post('/set-lang', function () {
    $lang = request('lang', 'ar');
    if (in_array($lang, ['ar', 'en'])) {
        session(['lang' => $lang]);
    }
    return response()->json(['success' => true]);
})->name('set-lang');

// خدمة ملفات اللغة للـ JavaScript
Route::get('/lang/{lang}.json', function (string $lang) {
    if (!in_array($lang, ['ar', 'en'])) {
        abort(404);
    }
    $path = base_path("lang/{$lang}.json");
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path, ['Content-Type' => 'application/json; charset=utf-8']);
})->where('lang', 'ar|en')->name('lang.json');

// ==========================================
// Asset Auto-Discovery API (Public — no auth)
// ==========================================
Route::get('/api/patterns', [PageController::class, 'apiPatterns'])->name('api.patterns');
Route::get('/api/fabrics',  [PageController::class, 'apiFabrics'])->name('api.fabrics');

// ==========================================
// صفحات المشارك (محمية بـ ParticipantAuth)
// ==========================================
// صفحات عامة (Public) - لا تتطلب تسجيل دخول المشارك
Route::get('/morris', [PageController::class, 'morris'])->name('morris');
Route::get('/fabrics', [PageController::class, 'fabrics'])->name('fabrics');
Route::get('/technique', [PageController::class, 'technique'])->name('technique');

// صفحات المشارك (محمية بـ ParticipantAuth)
Route::middleware('participant.auth')->group(function () {
    Route::get('/design-tool', [PageController::class, 'designTool'])->name('design-tool');

    Route::get('/survey', [SurveyController::class, 'show'])->name('survey');
    Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
    Route::get('/thank-you', [SurveyController::class, 'thankYou'])->name('thank-you');

    Route::post('/save-design-choice', [SurveyController::class, 'saveDesignChoice'])->name('save-design-choice');

    Route::post('/designs', [SavedDesignController::class, 'store'])->name('designs.store');
    Route::get('/designs', [SavedDesignController::class, 'index'])->name('designs.index');
    Route::delete('/designs/{id}', [SavedDesignController::class, 'destroy'])->name('designs.destroy');
});

// ==========================================
// لوحة التحكم (محمية بـ AdminAuth)
// ==========================================
Route::get('/admin/login',   [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login',  [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware('admin.auth')->name('admin.')->group(function () {
    Route::get('/',                  fn() => redirect()->route('admin.dashboard'));
    Route::get('dashboard',          [DashboardController::class, 'index'])->name('dashboard');

    // Assets
    Route::get('assets/fabrics',     [AssetController::class, 'fabricsIndex'])->name('assets.fabrics');
    Route::get('assets/patterns',    [AssetController::class, 'patternsIndex'])->name('assets.patterns');
    Route::post('assets/upload',     [AssetController::class, 'store'])->name('assets.upload');
    Route::delete('assets/{type}/{filename}', [AssetController::class, 'destroy'])->name('assets.destroy');

    // Content (educational pages)
    Route::get('content/{slug}',     [ContentController::class, 'show'])->name('content.show');
    Route::post('content/{slug}',    [ContentController::class, 'update'])->name('content.update');

    // Participants
    Route::resource('participants',   ParticipantController::class)->only(['index', 'store', 'destroy']);

    // Saved Designs
    Route::get('designs',            [DesignController::class, 'index'])->name('designs.index');

    // Responses (existing)
    Route::get('responses',          [ResponseController::class, 'index'])->name('responses.index');
    Route::get('responses/export',   [ResponseController::class, 'export'])->name('responses.export');
});
