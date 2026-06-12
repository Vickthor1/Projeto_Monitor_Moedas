const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');
const mobileMenuToggle = document.getElementById('mobileMenuToggle');
const mobileDrawer = document.getElementById('mobileDrawer');
const mobileClose = document.getElementById('mobileMenuClose');
const convertForm = document.getElementById('currencyConversionForm');
const convertButton = document.getElementById('convertButton');
const swapButton = document.getElementById('swapButton');
const originSelect = document.getElementById('moeda_origem');
const destinationSelect = document.getElementById('moeda_destino');

function getTheme() {
    const savedTheme = localStorage.getItem('theme');

    if (savedTheme === 'light' || savedTheme === 'dark') {
        return savedTheme;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

function applyTheme(theme) {
    document.body.dataset.theme = theme;
    localStorage.setItem('theme', theme);

    if (themeIcon) {
        themeIcon.textContent = theme === 'dark' ? '🌙' : '☀️';
    }
}

function toggleTheme() {
    const currentTheme = document.body.dataset.theme === 'light' ? 'light' : 'dark';
    applyTheme(currentTheme === 'light' ? 'dark' : 'light');
}

function showToast(message, type = 'info') {
    const container = document.querySelector('.toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.role = 'status';
    toast.ariaLive = 'polite';
    toast.innerHTML = `
        <div>
            <p class="font-semibold">${type.charAt(0).toUpperCase() + type.slice(1)}</p>
            <p class="text-sm text-slate-300">${message}</p>
        </div>
        <button type="button" class="toast-close" aria-label="Fechar alerta">×</button>
    `;

    container.appendChild(toast);

    const removeToast = () => {
        toast.classList.add('toast-exit');
        toast.addEventListener('animationend', () => toast.remove(), { once: true });
    };

    toast.querySelector('.toast-close')?.addEventListener('click', removeToast);
    setTimeout(removeToast, 5200);
}

function initMobileMenu() {
    if (!mobileDrawer || !mobileMenuToggle || !mobileClose) {
        return;
    }

    mobileMenuToggle.addEventListener('click', () => mobileDrawer.classList.add('open'));
    mobileClose.addEventListener('click', () => mobileDrawer.classList.remove('open'));
    mobileDrawer.addEventListener('click', (event) => {
        if (event.target === mobileDrawer) {
            mobileDrawer.classList.remove('open');
        }
    });
}

function initCurrencySwap() {
    if (!swapButton || !originSelect || !destinationSelect) {
        return;
    }

    swapButton.addEventListener('click', (event) => {
        event.preventDefault();
        const originValue = originSelect.value;
        originSelect.value = destinationSelect.value;
        destinationSelect.value = originValue;
        swapButton.classList.add('animate-swap');
        setTimeout(() => swapButton.classList.remove('animate-swap'), 320);
    });
}

function animateNumber(element, value, duration = 900) {
    const startValue = Number(element.textContent.replace(/[.,]/g, '')) || 0;
    const finalValue = Number(value);
    const startTime = performance.now();

    const easeOut = (t) => 1 - Math.pow(1 - t, 3);

    function update(now) {
        const progress = Math.min((now - startTime) / duration, 1);
        const current = startValue + (finalValue - startValue) * easeOut(progress);
        element.textContent = new Intl.NumberFormat('pt-BR', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(Math.round(current));

        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }

    requestAnimationFrame(update);
}

function initConversionForm() {
    if (!convertForm || !convertButton) {
        return;
    }

    convertForm.addEventListener('submit', () => {
        convertButton.disabled = true;
        convertButton.classList.add('btn-loading');
        convertButton.innerHTML = `
            <svg class="h-5 w-5 animate-spin text-slate-900" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span>Consultando...</span>
        `;
    });
}

function initPage() {
    applyTheme(getTheme());
    if (themeToggle) themeToggle.addEventListener('click', toggleTheme);
    initMobileMenu();
    initCurrencySwap();
    initConversionForm();

    document.querySelectorAll('[data-animate-number]').forEach((element) => {
        animateNumber(element, element.dataset.value || element.textContent);
    });
}

document.addEventListener('DOMContentLoaded', initPage);
