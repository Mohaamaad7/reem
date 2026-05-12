const CACHE_NAME = 'rawnaq-v1';
const STATIC_CACHE = 'rawnaq-static-v1';
const DYNAMIC_CACHE = 'rawnaq-dynamic-v1';

// الـ assets التي يتم cache-ها مسبقاً
const PRE_CACHE_ASSETS = [
    '/',
    '/manifest.json',
    '/images/icons/icon-192.png',
    '/images/icons/icon-512.png',
];

// المسارات التي لا يُطبق عليها caching
const NO_CACHE_PATHS = [
    '/admin',
    '/login',
    '/logout',
    '/survey',
    '/save-design-choice',
    '/set-lang',
];

// ==========================================
// Install Event — Pre-cache static assets
// ==========================================
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE).then((cache) => {
            return cache.addAll(PRE_CACHE_ASSETS);
        }).then(() => self.skipWaiting())
    );
});

// ==========================================
// Activate Event — Clean old caches
// ==========================================
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys
                    .filter((key) => key !== STATIC_CACHE && key !== DYNAMIC_CACHE)
                    .map((key) => caches.delete(key))
            );
        }).then(() => self.clients.claim())
    );
});

// ==========================================
// Fetch Event — Cache strategy
// ==========================================
self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);

    // لا نـ cache طلبات POST
    if (event.request.method !== 'GET') return;

    // لا نـ cache مسارات /admin/* والمسارات الحساسة
    const shouldSkip = NO_CACHE_PATHS.some(path => url.pathname.startsWith(path));
    if (shouldSkip) return;

    // الـ assets (CSS, JS, fonts, images) — Cache First
    if (
        url.pathname.startsWith('/build/') ||
        url.pathname.startsWith('/fonts/') ||
        url.pathname.startsWith('/images/fabrics/') ||
        url.pathname.startsWith('/images/patterns/') ||
        url.pathname.startsWith('/images/morris-gallery/')
    ) {
        event.respondWith(cacheFirst(event.request));
        return;
    }

    // الصفحات — Network First مع Fallback
    event.respondWith(networkFirst(event.request));
});

// ==========================================
// Cache Strategies
// ==========================================
async function cacheFirst(request) {
    const cached = await caches.match(request);
    if (cached) return cached;

    try {
        const response = await fetch(request);
        const cache = await caches.open(STATIC_CACHE);
        cache.put(request, response.clone());
        return response;
    } catch {
        return new Response('Offline', { status: 503 });
    }
}

async function networkFirst(request) {
    const cache = await caches.open(DYNAMIC_CACHE);

    try {
        const response = await fetch(request);
        cache.put(request, response.clone());
        return response;
    } catch {
        const cached = await cache.match(request);
        return cached || new Response(
            '<h1>أنتِ غير متصلة بالإنترنت</h1><p>يرجى الاتصال والمحاولة مجدداً</p>',
            { headers: { 'Content-Type': 'text/html; charset=utf-8' } }
        );
    }
}

// ==========================================
// Background Sync للاستبيان (offline support)
// ==========================================
self.addEventListener('sync', (event) => {
    if (event.tag === 'sync-survey') {
        event.waitUntil(syncSurvey());
    }
});

async function syncSurvey() {
    // سيتم تنفيذ هذا عند عودة الاتصال
    const db = await openDB();
    const pendingSurveys = await getPendingSurveys(db);

    for (const survey of pendingSurveys) {
        try {
            await fetch('/survey', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(survey),
            });
            await removePendingSurvey(db, survey.id);
        } catch (e) {
            console.error('Failed to sync survey:', e);
        }
    }
}

// IndexedDB helpers (placeholder — سيتم تطويرها في Phase 5)
function openDB() { return Promise.resolve(null); }
function getPendingSurveys() { return Promise.resolve([]); }
function removePendingSurvey() { return Promise.resolve(); }
