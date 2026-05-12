/**
 * lang.js — نظام تعدد اللغات لـ Rawnaq
 * يدعم: عربي (RTL) وإنجليزي (LTR) بدون إعادة تحميل الصفحة
 */

// ==========================================
// Language Data — يتم تحميلها من ملفات JSON
// ==========================================
const LANG_DATA = {};

async function loadLanguage(lang) {
    if (LANG_DATA[lang]) return LANG_DATA[lang];

    try {
        const res = await fetch(`/lang/${lang}.json`);
        if (!res.ok) throw new Error(`Failed to load ${lang}.json`);
        LANG_DATA[lang] = await res.json();
        return LANG_DATA[lang];
    } catch (e) {
        console.error('Language load error:', e);
        return {};
    }
}

// ==========================================
// دالة الترجمة t(key)
// ==========================================
function t(key, lang = null) {
    const currentLang = lang || getCurrentLang();
    const data = LANG_DATA[currentLang] || {};

    const parts = key.split('.');
    let value = data;

    for (const part of parts) {
        if (value && typeof value === 'object') {
            value = value[part];
        } else {
            return key; // fallback: المفتاح نفسه
        }
    }

    return value || key;
}

// ==========================================
// تحديد اللغة الحالية
// ==========================================
function getCurrentLang() {
    return localStorage.getItem('nw_lang') || document.documentElement.lang || 'ar';
}

// ==========================================
// تطبيق اللغة على كامل الصفحة
// ==========================================
async function applyLanguage(lang) {
    await loadLanguage(lang);

    // تحديث اتجاه الصفحة
    document.documentElement.lang = lang;
    document.documentElement.dir  = lang === 'ar' ? 'rtl' : 'ltr';

    // تحديث كل العناصر التي تحمل data-lang-key
    document.querySelectorAll('[data-lang-key]').forEach(el => {
        const key   = el.getAttribute('data-lang-key');
        const attr  = el.getAttribute('data-lang-attr'); // مثال: placeholder
        const value = t(key, lang);

        if (attr) {
            el.setAttribute(attr, value);
        } else {
            el.textContent = value;
        }
    });

    // تحديث الـ placeholder بشكل خاص
    document.querySelectorAll('[data-lang-placeholder]').forEach(el => {
        const key = el.getAttribute('data-lang-placeholder');
        el.placeholder = t(key, lang);
    });

    // حفظ اللغة في localStorage
    localStorage.setItem('nw_lang', lang);

    // مزامنة مع الـ server session
    syncLangWithServer(lang);

    // إطلاق حدث مخصص
    document.dispatchEvent(new CustomEvent('langChanged', { detail: { lang } }));
}

// ==========================================
// مزامنة اللغة مع الـ server
// ==========================================
async function syncLangWithServer(lang) {
    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        await fetch('/set-lang', {
            method: 'POST',
            headers: {
                'Content-Type':  'application/json',
                'X-CSRF-TOKEN':  token || '',
            },
            body: JSON.stringify({ lang }),
        });
    } catch (e) {
        // صامت — اللغة محفوظة في localStorage على أي حال
    }
}

// ==========================================
// زر تبديل اللغة
// ==========================================
function initLanguageSwitcher() {
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-lang-switch]');
        if (!btn) return;

        const lang = btn.getAttribute('data-lang-switch');
        if (lang) {
            applyLanguage(lang);

            // تحديث حالة الأزرار
            document.querySelectorAll('[data-lang-switch]').forEach(b => {
                b.classList.toggle('active', b.getAttribute('data-lang-switch') === lang);
            });
        }
    });
}

// ==========================================
// التهيئة عند تحميل الصفحة
// ==========================================
async function initLang() {
    const lang = getCurrentLang();
    await applyLanguage(lang);
    initLanguageSwitcher();

    // تحديث حالة الأزرار
    document.querySelectorAll('[data-lang-switch]').forEach(btn => {
        btn.classList.toggle('active', btn.getAttribute('data-lang-switch') === lang);
    });
}

// تصدير الدوال للاستخدام في ملفات أخرى
window.NW = window.NW || {};
window.NW.t    = t;
window.NW.lang = getCurrentLang;
window.NW.applyLanguage = applyLanguage;

// تشغيل التهيئة
document.addEventListener('DOMContentLoaded', initLang);
