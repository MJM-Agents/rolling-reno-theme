/**
 * Rolling Reno v2 — Main JavaScript
 * Sticky nav, mobile menu, TOC generation, smooth scroll, gear tabs
 */

(function () {
  'use strict';

  // ─── Utility ────────────────────────────────────────────────────────────────

  function throttle(fn, ms) {
    let last = 0;
    return function (...args) {
      const now = Date.now();
      if (now - last >= ms) { last = now; fn.apply(this, args); }
    };
  }

  function debounce(fn, ms) {
    let timer;
    return function (...args) {
      clearTimeout(timer);
      timer = setTimeout(() => fn.apply(this, args), ms);
    };
  }

  // ─── Sticky Nav ─────────────────────────────────────────────────────────────

  function initStickyNav() {
    const nav = document.getElementById('site-nav');
    if (!nav) return;

    const SCROLL_THRESHOLD = 80;

    function updateNav() {
      if (window.scrollY > SCROLL_THRESHOLD) {
        nav.classList.add('site-nav--scrolled');
      } else {
        nav.classList.remove('site-nav--scrolled');
      }
    }

    // Run on load
    updateNav();
    window.addEventListener('scroll', throttle(updateNav, 50), { passive: true });
  }

  // ─── Mobile Menu ────────────────────────────────────────────────────────────

  function initMobileMenu() {
    const hamburger = document.querySelector('.site-nav__hamburger');
    const mobileMenu = document.getElementById('mobile-menu');
    if (!hamburger || !mobileMenu) return;

    hamburger.addEventListener('click', function () {
      const isOpen = this.getAttribute('aria-expanded') === 'true';
      this.setAttribute('aria-expanded', String(!isOpen));
      mobileMenu.setAttribute('aria-hidden', String(isOpen));
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
      if (!hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
        hamburger.setAttribute('aria-expanded', 'false');
        mobileMenu.setAttribute('aria-hidden', 'true');
      }
    });

    // Close on Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        hamburger.setAttribute('aria-expanded', 'false');
        mobileMenu.setAttribute('aria-hidden', 'true');
        hamburger.focus();
      }
    });
  }

  // ─── Scroll Indicator ───────────────────────────────────────────────────────

  function initScrollIndicator() {
    const indicator = document.querySelector('.hero__scroll-indicator');
    if (!indicator) return;

    function checkScroll() {
      if (window.scrollY > 100) {
        indicator.style.opacity = '0';
        indicator.style.pointerEvents = 'none';
      } else {
        indicator.style.opacity = '';
        indicator.style.pointerEvents = '';
      }
    }
    window.addEventListener('scroll', throttle(checkScroll, 100), { passive: true });
  }

  // ─── Table of Contents ──────────────────────────────────────────────────────

  function initTOC() {
    const toc = document.querySelector('.toc');
    const postBody = document.querySelector('.post-body');
    if (!postBody) return;

    // Auto-generate TOC from H2s in post body
    const headings = postBody.querySelectorAll('h2');
    const tocList = document.getElementById('toc-list');

    if (!tocList || headings.length < 4) {
      // Hide TOC if fewer than 4 headings
      if (toc) toc.style.display = 'none';
      return;
    }

    // Ensure each heading has an ID
    headings.forEach(function (h, i) {
      if (!h.id) {
        h.id = 'section-' + (i + 1);
      }
      const li = document.createElement('li');
      li.className = 'toc__item';
      const a = document.createElement('a');
      a.className = 'toc__link';
      a.href = '#' + h.id;
      a.textContent = h.textContent;
      li.appendChild(a);
      tocList.appendChild(li);
    });

    // Collapsible toggle
    const toggle = document.querySelector('.toc__toggle');
    if (toggle) {
      toggle.addEventListener('click', function () {
        const collapsed = toc.getAttribute('data-collapsed') === 'true';
        toc.setAttribute('data-collapsed', String(!collapsed));
        this.setAttribute('aria-expanded', String(collapsed));
      });
    }

    // Active section highlight on scroll
    const tocLinks = tocList.querySelectorAll('.toc__link');

    function updateActiveTOC() {
      let activeId = null;
      headings.forEach(function (h) {
        const rect = h.getBoundingClientRect();
        if (rect.top <= 120) activeId = h.id;
      });
      tocLinks.forEach(function (link) {
        if (link.getAttribute('href') === '#' + activeId) {
          link.classList.add('toc__link--active');
        } else {
          link.classList.remove('toc__link--active');
        }
      });
    }
    window.addEventListener('scroll', throttle(updateActiveTOC, 100), { passive: true });
  }

  // ─── Smooth Scroll ──────────────────────────────────────────────────────────

  function initSmoothScroll() {
    // Smooth scroll for TOC links and anchor links
    document.addEventListener('click', function (e) {
      const link = e.target.closest('a[href^="#"]');
      if (!link) return;

      const targetId = link.getAttribute('href').slice(1);
      if (!targetId) return;

      const target = document.getElementById(targetId);
      if (!target) return;

      e.preventDefault();

      const navHeight = 72; // sticky nav height
      const tabsEl = document.querySelector('.gear-tabs');
      const tabsHeight = tabsEl ? tabsEl.offsetHeight : 0;
      const offset = navHeight + tabsHeight + 16;

      const top = target.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top, behavior: 'smooth' });

      // Update URL without triggering scroll
      history.pushState(null, '', '#' + targetId);

      // Move focus for a11y
      target.setAttribute('tabindex', '-1');
      target.focus({ preventScroll: true });
    });
  }

  // ─── Gear Page Tabs ─────────────────────────────────────────────────────────

  function initGearTabs() {
    const tabs = document.querySelectorAll('.gear-tab');
    if (!tabs.length) return;

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function (e) {
        // Remove active from all
        tabs.forEach(t => {
          t.classList.remove('is-active');
          t.setAttribute('aria-selected', 'false');
        });
        // Set active on clicked
        this.classList.add('is-active');
        this.setAttribute('aria-selected', 'true');
      });
    });
  }

  // ─── Gear Strip Keyboard Scroll ─────────────────────────────────────────────

  function initGearStripKeyboard() {
    const strip = document.querySelector('.gear-strip__scroll');
    if (!strip) return;

    strip.setAttribute('tabindex', '0');
    strip.setAttribute('role', 'region');

    strip.addEventListener('keydown', function (e) {
      const cardWidth = 220 + 20; // flex + gap
      if (e.key === 'ArrowRight') {
        e.preventDefault();
        this.scrollBy({ left: cardWidth, behavior: 'smooth' });
      } else if (e.key === 'ArrowLeft') {
        e.preventDefault();
        this.scrollBy({ left: -cardWidth, behavior: 'smooth' });
      }
    });
  }

  // ─── Category Filters ───────────────────────────────────────────────────────

  function initCategoryFilters() {
    const filters = document.querySelectorAll('.category-filter');
    if (!filters.length) return;

    filters.forEach(function (filter) {
      filter.addEventListener('click', function (e) {
        filters.forEach(f => {
          f.classList.remove('is-active');
          f.removeAttribute('aria-current');
        });
        this.classList.add('is-active');
        this.setAttribute('aria-current', 'page');
      });
    });
  }

  // ─── Email Form Success Swap ─────────────────────────────────────────────────

  function initEmailForms() {
    const forms = document.querySelectorAll('.cta-banner__form, .mid-post-optin__form');

    forms.forEach(function (form) {
      form.addEventListener('submit', function (e) {
        // Only show success UI if it's a demo (no real action set)
        const action = this.getAttribute('action');
        if (!action || action === '/subscribe') {
          e.preventDefault();
          const successMsg = document.createElement('p');
          successMsg.style.cssText = 'color: var(--color-text-inverse); font-size: 18px; font-weight: 700; padding: 12px 0;';
          successMsg.textContent = '✓ It\'s on its way! Check your inbox.';
          this.replaceWith(successMsg);
        }
      });
    });
  }

  // ─── Reading Progress Bar (optional) ────────────────────────────────────────

  function initReadingProgress() {
    const postBody = document.querySelector('.post-body');
    if (!postBody) return;

    // Create progress bar
    const bar = document.createElement('div');
    bar.setAttribute('aria-hidden', 'true');
    bar.style.cssText = [
      'position: fixed',
      'top: 72px',
      'left: 0',
      'height: 3px',
      'background: var(--color-terracotta)',
      'width: 0%',
      'z-index: 99',
      'transition: width 100ms linear',
      'pointer-events: none',
    ].join(';');
    document.body.appendChild(bar);

    function updateProgress() {
      const bodyRect = postBody.getBoundingClientRect();
      const bodyHeight = postBody.offsetHeight;
      const scrolled = -bodyRect.top;
      const progress = Math.min(Math.max(scrolled / bodyHeight, 0), 1);
      bar.style.width = (progress * 100).toFixed(1) + '%';
    }

    window.addEventListener('scroll', throttle(updateProgress, 60), { passive: true });
  }

  // ─── Search Button Placeholder ───────────────────────────────────────────────

  function initSearchBtn() {
    const searchBtns = document.querySelectorAll('.site-nav__search-btn');
    searchBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        // Trigger WordPress native search if available, else simple focus
        const searchInput = document.querySelector('input[type="search"]');
        if (searchInput) {
          searchInput.focus();
        } else {
          // Attempt to navigate to search
          window.location.href = '/?s=';
        }
      });
    });
  }

  // ─── Lazy Load Fallback (for browsers without native lazy) ──────────────────

  function initLazyLoadFallback() {
    if ('loading' in HTMLImageElement.prototype) return; // native support

    const images = document.querySelectorAll('img[loading="lazy"]');
    if (!images.length) return;

    if ('IntersectionObserver' in window) {
      const io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            const img = entry.target;
            if (img.dataset.src) { img.src = img.dataset.src; }
            io.unobserve(img);
          }
        });
      }, { rootMargin: '200px' });
      images.forEach(img => io.observe(img));
    }
  }

  // ─── Init ────────────────────────────────────────────────────────────────────

  function init() {
    initStickyNav();
    initMobileMenu();
    initScrollIndicator();
    initTOC();
    initSmoothScroll();
    initGearTabs();
    initGearStripKeyboard();
    initCategoryFilters();
    initEmailForms();
    initReadingProgress();
    initSearchBtn();
    initLazyLoadFallback();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
