/* ========================================
   Portal Wisata & Budaya Delta Brantas
   Main JavaScript
   ======================================== */

document.addEventListener('DOMContentLoaded', function () {

    // ========================================
    // NAVBAR SCROLL EFFECT
    // ========================================
    const navbar = document.querySelector('.navbar');

    function handleNavbarScroll() {
        if (!navbar) return;
        if (window.scrollY > 60) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }

    window.addEventListener('scroll', handleNavbarScroll, { passive: true });
    handleNavbarScroll();

    // ========================================
    // MOBILE MENU TOGGLE
    // ========================================
    const toggleBtn = document.querySelector('.navbar-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    const mobileLinks = mobileMenu ? mobileMenu.querySelectorAll('a') : [];

    if (toggleBtn && mobileMenu) {
        toggleBtn.addEventListener('click', function () {
            this.classList.toggle('active');
            mobileMenu.classList.toggle('open');
            document.body.style.overflow = mobileMenu.classList.contains('open') ? 'hidden' : '';
        });

        mobileLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                toggleBtn.classList.remove('active');
                mobileMenu.classList.remove('open');
                document.body.style.overflow = '';
            });
        });
    }

    // ========================================
    // HERO LOADED ANIMATION
    // ========================================
    const hero = document.querySelector('.hero');
    if (hero) {
        setTimeout(function () {
            hero.classList.add('loaded');
        }, 100);
    }

    // ========================================
    // SMOOTH SCROLL FOR ANCHOR LINKS
    // ========================================
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            var targetId = this.getAttribute('href');
            if (targetId === '#') return;
            var target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                var offsetTop = target.getBoundingClientRect().top + window.scrollY - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ========================================
    // INTERSECTION OBSERVER - REVEAL ANIMATIONS
    // ========================================
    var revealElements = document.querySelectorAll('.reveal');

    if ('IntersectionObserver' in window && revealElements.length > 0) {
        var revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        revealElements.forEach(function (el) {
            revealObserver.observe(el);
        });
    } else {
        // Fallback: show all immediately
        revealElements.forEach(function (el) {
            el.classList.add('revealed');
        });
    }

    // ========================================
    // COUNT-UP ANIMATION FOR STATISTICS
    // ========================================
    var statNumbers = document.querySelectorAll('.stat-number[data-target]');

    function animateCountUp(el) {
        var target = parseInt(el.getAttribute('data-target'), 10);
        var suffix = el.getAttribute('data-suffix') || '';
        var duration = 2000;
        var startTime = null;

        function easeOutQuart(t) {
            return 1 - Math.pow(1 - t, 4);
        }

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var easedProgress = easeOutQuart(progress);
            var current = Math.floor(easedProgress * target);
            el.textContent = current.toLocaleString('id-ID') + suffix;
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = target.toLocaleString('id-ID') + suffix;
            }
        }

        requestAnimationFrame(step);
    }

    if ('IntersectionObserver' in window && statNumbers.length > 0) {
        var countObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCountUp(entry.target);
                    countObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        statNumbers.forEach(function (el) {
            countObserver.observe(el);
        });
    } else {
        statNumbers.forEach(function (el) {
            var target = el.getAttribute('data-target');
            var suffix = el.getAttribute('data-suffix') || '';
            el.textContent = parseInt(target, 10).toLocaleString('id-ID') + suffix;
        });
    }

    // ========================================
    // PARALLAX EFFECT FOR HERO
    // ========================================
    var heroBg = document.querySelector('.hero-bg img');

    if (heroBg) {
        window.addEventListener('scroll', function () {
            var scrolled = window.scrollY;
            if (scrolled < window.innerHeight) {
                heroBg.style.transform = 'scale(1.1) translateY(' + (scrolled * 0.3) + 'px)';
            }
        }, { passive: true });
    }

    // ========================================
    // ACTIVE NAV LINK BASED ON CURRENT URL
    // ========================================
    var navLinks = document.querySelectorAll('.navbar-menu a');
    var currentPath = window.location.pathname;

    if (navLinks.length > 0) {
        navLinks.forEach(function (link) {
            var href = link.getAttribute('href');
            if (href === '/' && currentPath === '/') {
                link.classList.add('active');
            } else if (href !== '/' && currentPath.startsWith(href)) {
                link.classList.add('active');
            } else if (href === '/' && currentPath !== '/') {
                link.classList.remove('active');
            }
        });
    }

    // Force navbar scrolled state on inner pages
    if (currentPath !== '/') {
        if (navbar) navbar.classList.add('scrolled');
    }

});
