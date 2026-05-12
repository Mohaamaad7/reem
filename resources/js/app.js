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
            navigator.serviceWorker.register('/sw.js').catch(() => {});
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initHeaderToggle();
    initServiceWorker();
});
