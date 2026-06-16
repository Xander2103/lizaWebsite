import './bootstrap';

// Scroll reveal — observes .reveal and .reveal-stagger elements
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12 }
    );

    document.querySelectorAll('.reveal, .reveal-stagger').forEach((el) => {
        observer.observe(el);
    });
});

// Mobile nav toggle
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('.nav-toggle');
    const panel  = document.querySelector('.nav-mobile-panel');

    if (toggle && panel) {
        toggle.addEventListener('click', () => {
            panel.classList.toggle('is-open');
            const isOpen = panel.classList.contains('is-open');
            toggle.setAttribute('aria-expanded', String(isOpen));
        });

        // Close on link click (single-page smooth scroll)
        panel.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => panel.classList.remove('is-open'));
        });
    }
});

// Transparent header over hero, solid white once scrolled past
document.addEventListener('DOMContentLoaded', () => {
    const nav  = document.querySelector('.nav-bar');
    const hero = document.querySelector('#hero');

    if (nav && hero) {
        const navHeight = nav.offsetHeight;

        const headerObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    nav.classList.toggle('nav-bar--transparent', entry.isIntersecting);
                });
            },
            { rootMargin: `-${navHeight}px 0px 0px 0px`, threshold: 0 }
        );

        headerObserver.observe(hero);
    }
});
