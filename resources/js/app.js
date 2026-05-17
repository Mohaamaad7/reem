import './lang';

function initHeaderToggle() {
    const toggle = document.querySelector('[data-header-toggle]');
    const nav = document.querySelector('[data-site-nav]');
    const actions = document.querySelector('[data-header-actions]');

    if (!toggle || !nav || !actions) {
        return;
    }

    toggle.addEventListener('click', () => {
        const isOpen = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!isOpen));
        nav.classList.toggle('is-open', !isOpen);
        actions.classList.toggle('is-open', !isOpen);
    });
}

function initServiceWorker() {
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            const meta = document.querySelector('meta[name="base-url"]');
            const baseUrl = meta ? meta.content : '';
            navigator.serviceWorker.register(baseUrl + '/sw.js').catch(() => {});
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initHeaderToggle();
    initServiceWorker();
});
