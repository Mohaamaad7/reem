@if(!$isLoggedIn)
<div id="login-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-morris-text/40 modal-backdrop transition-opacity" data-close-modal></div>

    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 p-8 overflow-hidden border border-morris-border transform transition-all scale-95 opacity-0 duration-300" id="modal-panel">
        <svg class="absolute top-0 left-0 w-16 h-16 text-morris-primary/5 -translate-x-4 -translate-y-4" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
        <svg class="absolute bottom-0 right-0 w-24 h-24 text-morris-gold/10 translate-x-8 translate-y-8" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>

        <button type="button" data-close-modal class="absolute top-4 left-4 text-morris-text/50 hover:text-morris-terracotta transition-colors bg-morris-cream rounded-full p-2" aria-label="إغلاق">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="relative text-center">
            <div class="font-brand text-3xl text-morris-primary mb-2" id="modal-title">أهلاً بكِ في رونق</div>
            <p class="text-morris-text/70 mb-8 text-sm">أدخلي كود المشاركة للوصول إلى هذا القسم والمتابعة</p>

            <form id="modal-form" class="space-y-6" novalidate>
                <div>
                    <label for="modal-code" class="block text-right text-sm font-semibold text-morris-text mb-2">كود المشاركة</label>
                    <input
                        type="text"
                        id="modal-code"
                        name="code"
                        maxlength="4"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        placeholder="مثال: 1234"
                        class="w-full text-center text-2xl tracking-[0.5em] font-bold text-morris-primary bg-morris-cream border-2 border-morris-border rounded-xl px-4 py-4 focus:outline-none focus:border-morris-gold focus:ring-1 focus:ring-morris-gold transition-all"
                    >
                    <p id="modal-error" class="text-red-500 text-sm mt-2 hidden">يرجى إدخال كود صحيح</p>
                </div>

                <button type="submit" id="modal-submit" class="w-full bg-morris-terracotta hover:bg-morris-primary text-white font-bold text-lg py-4 rounded-xl shadow-md transition-colors duration-300 relative overflow-hidden group disabled:opacity-60 disabled:cursor-not-allowed">
                    <span class="relative z-10" id="modal-submit-label">ابدئي التجربة</span>
                    <div class="absolute inset-0 h-full w-full bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-out"></div>
                </button>
            </form>

            <p class="mt-6 text-xs text-morris-text/50">الرجاء استخدام كود المشاركة المكون من 4 أرقام المرسل لكِ مسبقاً.</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal       = document.getElementById('login-modal');
    const modalPanel  = document.getElementById('modal-panel');
    const openBtns    = document.querySelectorAll('[data-open-login-modal]');
    const closeBtns   = document.querySelectorAll('[data-close-modal]');
    const form        = document.getElementById('modal-form');
    const input       = document.getElementById('modal-code');
    const errorMsg    = document.getElementById('modal-error');
    const submitBtn   = document.getElementById('modal-submit');
    const submitLabel = document.getElementById('modal-submit-label');
    const csrfToken   = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const showError = (msg) => {
        errorMsg.textContent = msg || 'يرجى إدخال كود صحيح';
        errorMsg.classList.remove('hidden');
        input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        modalPanel.classList.add('animate-pulse');
        setTimeout(() => modalPanel.classList.remove('animate-pulse'), 500);
    };

    const clearError = () => {
        errorMsg.classList.add('hidden');
        input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
    };

    const openModal = (e) => {
        if (e) e.preventDefault();
        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            modalPanel.classList.remove('scale-95', 'opacity-0');
            modalPanel.classList.add('scale-100', 'opacity-100');
        });
        document.body.style.overflow = 'hidden';
        setTimeout(() => input.focus(), 300);
    };

    const closeModal = () => {
        modalPanel.classList.remove('scale-100', 'opacity-100');
        modalPanel.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            input.value = '';
            clearError();
        }, 300);
    };

    openBtns.forEach(btn => btn.addEventListener('click', openModal));
    closeBtns.forEach(btn => btn.addEventListener('click', closeModal));

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });

    input.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
        clearError();
    });

    @if(isset($autoOpenModal) && $autoOpenModal)
    openModal();
    @endif

    const setLoading = (on) => {
        submitBtn.disabled = on;
        input.disabled     = on;
        if (on) {
            submitLabel.innerHTML = '<span class="inline-flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> جاري التحقق...</span>';
        } else {
            submitLabel.textContent = 'ابدئي التجربة';
        }
    };

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearError();

        const code = input.value.trim();
        if (code.length !== 4) {
            showError('الرجاء إدخال كود مكون من 4 أرقام');
            return;
        }

        setLoading(true);
        try {
            const res = await fetch('{{ route("login.post") }}', {
                method: 'POST',
                headers: {
                    'Accept':       'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ code }),
            });

            const data = await res.json().catch(() => ({}));

            if (!res.ok) {
                showError(
                    data.error || data.errors?.code?.[0] || data.message || 'حدث خطأ، يرجى المحاولة مجدداً'
                );
                return;
            }

            window.location.href = data.redirect ?? '{{ route("home") }}';
        } catch (err) {
            showError('حدث خطأ في الاتصال، يرجى المحاولة مجدداً');
        } finally {
            setLoading(false);
        }
    });
});
</script>
@endif
