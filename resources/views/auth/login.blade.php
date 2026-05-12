<!DOCTYPE html>
<html lang="{{ session('lang', 'ar') }}" dir="{{ session('lang', 'ar') === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#8b6914">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <title>{{ session('lang', 'ar') === 'ar' ? 'تسجيل الدخول - رونق' : 'Login - Rawnaq' }}</title>
    @vite(['resources/css/app.css', 'resources/css/animations.css', 'resources/css/rtl.css', 'resources/js/app.js'])
</head>
<body>
    <main class="login-page">
        <section class="login-card surface-card fade-in" aria-labelledby="login-title">
            <div class="site-header__actions" style="justify-content: center; margin-bottom: 1.5rem;">
                <div class="language-switcher" aria-label="Language switcher">
                    <button class="language-switcher__button" type="button" data-lang-switch="ar">AR</button>
                    <button class="language-switcher__button" type="button" data-lang-switch="en">EN</button>
                </div>
            </div>

            <div class="login-logo" aria-hidden="true">NW</div>

            <h1 class="login-title" id="login-title" data-lang-key="login.title">
                {{ session('lang', 'ar') === 'ar' ? 'أهلاً بكِ في رونق' : 'Welcome to Rawnaq' }}
            </h1>

            <p class="login-subtitle" data-lang-key="login.subtitle">
                {{ session('lang', 'ar') === 'ar' ? 'تجربة تصميم الأقمشة المستدامة' : 'Sustainable Fabric Design Experience' }}
            </p>

            <form class="form-stack" id="participant-login-form" novalidate>
                <div>
                    <label class="form-label" for="participant-code" data-lang-key="login.label">
                        {{ session('lang', 'ar') === 'ar' ? 'كود المشاركة' : 'Participation Code' }}
                    </label>
                </div>

                <div>
                    <input
                        class="form-input"
                        id="participant-code"
                        name="code"
                        type="text"
                        inputmode="numeric"
                        maxlength="4"
                        autocomplete="one-time-code"
                        data-lang-placeholder="login.placeholder"
                        placeholder="{{ session('lang', 'ar') === 'ar' ? 'أدخلي الكود المكون من 4 أرقام' : 'Enter your 4-digit code' }}"
                    >
                </div>

                <p class="form-error" id="login-error" role="alert" aria-live="polite"></p>

                <button class="button" id="login-submit" type="submit" data-lang-key="login.button">
                    {{ session('lang', 'ar') === 'ar' ? 'ابدئي التجربة' : 'Start Experience' }}
                </button>
            </form>

            <p class="login-meta">
                <span data-lang-key="common.loading" data-loading-label hidden>
                    {{ session('lang', 'ar') === 'ar' ? 'جاري التحميل...' : 'Loading...' }}
                </span>
                <span>{{ session('lang', 'ar') === 'ar' ? 'الرجاء استخدام كود المشاركة المرسل لكِ.' : 'Please use the participation code shared with you.' }}</span>
            </p>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('participant-login-form');
            const input = document.getElementById('participant-code');
            const submitButton = document.getElementById('login-submit');
            const errorBox = document.getElementById('login-error');
            const loadingLabel = document.querySelector('[data-loading-label]');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

            const removeShake = () => {
                form.closest('.login-card')?.classList.remove('shake');
            };

            const triggerError = (message) => {
                errorBox.textContent = message;
                input.classList.add('has-error');
                const card = form.closest('.login-card');
                if (card) {
                    card.classList.remove('shake');
                    void card.offsetWidth;
                    card.classList.add('shake');
                }
            };

            const clearError = () => {
                errorBox.textContent = '';
                input.classList.remove('has-error');
                removeShake();
            };

            const setLoading = (isLoading) => {
                submitButton.disabled = isLoading;
                input.disabled = isLoading;
                if (loadingLabel) {
                    loadingLabel.hidden = !isLoading;
                }

                if (isLoading) {
                    const label = window.NW?.t ? window.NW.t('common.loading') : 'Loading...';
                    submitButton.textContent = label;
                } else {
                    const label = window.NW?.t ? window.NW.t('login.button') : 'Start Experience';
                    submitButton.textContent = label;
                }
            };

            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                clearError();

                const code = input.value.trim();

                if (!code) {
                    const message = window.NW?.t ? window.NW.t('login.placeholder') : 'Enter your 4-digit code';
                    triggerError(message);
                    return;
                }

                setLoading(true);

                try {
                    const response = await fetch('{{ route('login.post') }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ code }),
                    });

                    const payload = await response.json().catch(() => ({}));

                    if (!response.ok) {
                        const message =
                            payload.error ||
                            payload.errors?.code?.[0] ||
                            payload.message ||
                            (window.NW?.t ? window.NW.t('common.error') : 'An error occurred. Please try again.');
                        triggerError(message);
                        return;
                    }

                    if (payload.redirect) {
                        window.location.href = payload.redirect;
                    } else {
                        window.location.href = '{{ route('design-tool') }}';
                    }
                } catch (error) {
                    const message = window.NW?.t ? window.NW.t('common.error') : 'An error occurred. Please try again.';
                    triggerError(message);
                } finally {
                    setLoading(false);
                }
            });

            input.addEventListener('input', () => {
                input.value = input.value.replace(/[^\d]/g, '').slice(0, 4);
                if (errorBox.textContent) {
                    clearError();
                }
            });
        });
    </script>
</body>
</html>
