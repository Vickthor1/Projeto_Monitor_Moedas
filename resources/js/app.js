const mobileMenu = document.getElementById('mobileMenu');
const mobileMenuToggle = document.getElementById('mobileMenuToggle');
const mobileMenuClose = document.getElementById('mobileMenuClose');
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');

function setTheme(theme) {
    document.body.dataset.theme = theme;
    localStorage.setItem('theme', theme);

    if (themeIcon) {
        themeIcon.textContent = theme === 'dark' ? '🌙' : '☀️';
    }
}

function toggleTheme() {
    const currentTheme = document.body.dataset.theme === 'light' ? 'light' : 'dark';
    setTheme(currentTheme === 'light' ? 'dark' : 'light');
}

function openMobileMenu() {
    if (mobileMenu) {
        mobileMenu.classList.remove('hidden');
    }
}

function closeMobileMenu() {
    if (mobileMenu) {
        mobileMenu.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');

    if (savedTheme === 'light' || savedTheme === 'dark') {
        setTheme(savedTheme);
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        setTheme('dark');
    } else {
        setTheme('light');
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', toggleTheme);
    }

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', openMobileMenu);
    }

    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMobileMenu);
    }
});
