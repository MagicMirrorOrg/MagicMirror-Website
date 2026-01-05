// Mobile navbar toggle
const navToggle = document.getElementById('navToggle');
const navMenu = document.getElementById('navMenu');

navToggle.addEventListener('click', () => {
    navMenu.classList.toggle('active');
    navToggle.classList.toggle('active');
});

// Fade-in animation on scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
            setTimeout(() => entry.target.classList.add('visible'), index * 150);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.2, rootMargin: '0px 0px -50px 0px' });

document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));

// Theme toggle
const themeToggle = document.getElementById('themeToggle');
const themeIcon = themeToggle.querySelector('i');

// Check localStorage first, then system preference, fallback to light
const getInitialTheme = () => {
    const stored = localStorage.getItem('theme');
    if (stored) return stored;
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const setTheme = (theme) => {
    document.documentElement.setAttribute('data-theme', theme);
    themeIcon.className = theme === 'dark' 
        ? 'fa-solid fa-fw fa-sun' 
        : 'fa-solid fa-fw fa-moon';
    localStorage.setItem('theme', theme);
};

setTheme(getInitialTheme());

themeToggle.addEventListener('click', () => {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    setTheme(currentTheme === 'dark' ? 'light' : 'dark');
});

// Demo GIF modal
const demoGif = document.getElementById('demoGif');
const modal = document.getElementById('demoModal');
const modalImg = document.getElementById('modalImg');
const modalClose = document.querySelector('.modal-close');

demoGif.addEventListener('click', () => {
    modal.style.display = 'block';
    modalImg.src = demoGif.src;
});

modalClose.addEventListener('click', () => {
    modal.style.display = 'none';
});

modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});
