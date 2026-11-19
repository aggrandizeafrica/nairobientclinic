/* Nairobi ENT – 2026 redesign interactions (smooth scroll, header, menus, reveals). */
(function () {
  'use strict';
  var d = document, w = window, root = d.documentElement;
  var reduce = w.matchMedia && w.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var desktop = w.matchMedia('(min-width: 1061px)');
  root.classList.add('nent-js');

  /* ---- smooth scrolling ---- */
  var lenis = null;
  if (!reduce && typeof w.Lenis === 'function') {
    lenis = new w.Lenis({ duration: 1.15, easing: function (t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); }, smoothWheel: true, wheelMultiplier: 1, touchMultiplier: 1.4 });
    (function raf(t) { lenis.raf(t); requestAnimationFrame(raf); })(performance.now());
    w.nentLenis = lenis;
  }
  function scrollToY(target) {
    if (lenis) lenis.scrollTo(target, { offset: -90 });
    else if (typeof target === 'number') w.scrollTo({ top: target, behavior: reduce ? 'auto' : 'smooth' });
    else target.scrollIntoView({ behavior: reduce ? 'auto' : 'smooth' });
  }
  d.addEventListener('click', function (e) {
    var a = e.target.closest && e.target.closest('a[href^="#"]');
    if (!a) return;
    var id = a.getAttribute('href');
    if (id === '#' || id === '#page') { if (a.hasAttribute('data-nent-totop')) { e.preventDefault(); scrollToY(0); } return; }
    var el = d.querySelector(id);
    if (el && !a.closest('[data-elementor-open-lightbox]') && !a.hasAttribute('data-toggle')) { e.preventDefault(); scrollToY(el); }
  });

  /* ---- header state ---- */
  var header = d.querySelector('[data-nent-header]');
  var totop = d.querySelector('[data-nent-totop]');
  var lastY = 0, ticking = false;
  function onScroll() {
    var y = w.scrollY || w.pageYOffset;
    if (header) {
      header.classList.toggle('is-scrolled', y > 20);
      var openDrop = header.querySelector('.is-open');
      header.classList.toggle('is-hidden', y > 500 && y > lastY + 2 && !openDrop);
      if (y < lastY - 2) header.classList.remove('is-hidden');
    }
    if (totop) totop.classList.toggle('is-on', y > 700);
    parallax(y);
    words();
    lastY = y; ticking = false;
  }
  w.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(onScroll); } }, { passive: true });

  /* ---- dropdowns / mega menus ---- */
  var drops = [].slice.call(d.querySelectorAll('.nent-has-drop'));
  function closeAll(except) { drops.forEach(function (li) { if (li !== except) { li.classList.remove('is-open'); var b = li.querySelector('button'); if (b) b.setAttribute('aria-expanded', 'false'); } }); }
  drops.forEach(function (li) {
    var btn = li.querySelector('button'), timer;
    function open() { clearTimeout(timer); closeAll(li); li.classList.add('is-open'); btn.setAttribute('aria-expanded', 'true'); }
    function close() { li.classList.remove('is-open'); btn.setAttribute('aria-expanded', 'false'); }
    btn.addEventListener('click', function () { li.classList.contains('is-open') ? close() : open(); });
    li.addEventListener('mouseenter', function () { if (desktop.matches) open(); });
    li.addEventListener('mouseleave', function () { if (desktop.matches) { timer = setTimeout(close, 180); } });
    li.addEventListener('focusout', function (e) { if (!li.contains(e.relatedTarget)) close(); });
  });
  d.addEventListener('click', function (e) { if (!e.target.closest('.nent-has-drop')) closeAll(); });
  d.addEventListener('keydown', function (e) { if (e.key === 'Escape') { closeAll(); closeDrawer(); } });

  /* ---- mobile drawer ---- */
  var drawer = d.querySelector('[data-nent-drawer]');
  var burger = d.querySelector('[data-nent-burger]');
  function openDrawer() {
    if (!drawer) return;
    drawer.classList.add('is-open'); drawer.setAttribute('aria-hidden', 'false');
    burger.setAttribute('aria-expanded', 'true'); root.style.overflow = 'hidden'; root.classList.add('nent-menu-open');
    if (lenis) lenis.stop();
    var c = drawer.querySelector('[data-nent-close]'); if (c) setTimeout(function () { c.focus(); }, 50);
  }
  function closeDrawer() {
    if (!drawer || !drawer.classList.contains('is-open')) return;
    drawer.classList.remove('is-open'); drawer.setAttribute('aria-hidden', 'true');
    burger.setAttribute('aria-expanded', 'false'); root.style.overflow = ''; root.classList.remove('nent-menu-open');
    if (lenis) lenis.start();
    burger.focus();
  }
  if (burger) burger.addEventListener('click', openDrawer);
  if (drawer) {
    drawer.addEventListener('click', function (e) { if (e.target === drawer || e.target.closest('[data-nent-close]')) closeDrawer(); });
    drawer.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', function () { setTimeout(closeDrawer, 50); }); });
  }

  /* ---- reveal on scroll ---- */
  var revealEls = [].slice.call(d.querySelectorAll('[data-reveal]'));
  if ('IntersectionObserver' in w && !reduce) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); } });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-in'); });
  }

  /* ---- statement words light up while scrolling ---- */
  var stmt = d.querySelector('[data-nent-words]'), wordEls = [];
  if (stmt && !reduce) {
    var txt = stmt.textContent.trim().split(/\s+/);
    stmt.innerHTML = txt.map(function (t) { return '<span class="w">' + t.replace(/&/g, '&amp;').replace(/</g, '&lt;') + '</span>'; }).join(' ');
    wordEls = [].slice.call(stmt.querySelectorAll('.w'));
  }
  function words() {
    if (!wordEls.length) return;
    var r = stmt.getBoundingClientRect(), vh = w.innerHeight;
    var p = (vh * 0.85 - r.top) / (r.height + vh * 0.35);
    p = Math.max(0, Math.min(1, p));
    var n = Math.round(p * wordEls.length);
    for (var i = 0; i < wordEls.length; i++) wordEls[i].classList.toggle('on', i < n);
  }

  /* ---- gentle parallax on hero images ---- */
  var px = [].slice.call(d.querySelectorAll('[data-nent-parallax]'));
  function parallax(y) {
    if (reduce || !desktop.matches) return;
    px.forEach(function (el) { el.style.transform = 'translate3d(0,' + (y * parseFloat(el.getAttribute('data-nent-parallax'))).toFixed(1) + 'px,0)'; });
  }

  /* ---- counters ---- */
  var counters = [].slice.call(d.querySelectorAll('[data-nent-count]'));
  if (counters.length && 'IntersectionObserver' in w && !reduce) {
    var cio = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        var el = en.target, end = parseInt(el.getAttribute('data-nent-count'), 10), t0 = null;
        cio.unobserve(el);
        (function step(t) { if (!t0) t0 = t; var k = Math.min(1, (t - t0) / 1400); el.textContent = Math.round(end * (1 - Math.pow(1 - k, 3))); if (k < 1) requestAnimationFrame(step); })(performance.now());
      });
    }, { threshold: 0.6 });
    counters.forEach(function (el) { el.textContent = '0'; cio.observe(el); });
  }

  /* ---- tabs ---- */
  d.querySelectorAll('[data-nent-tabs]').forEach(function (box) {
    var tabs = [].slice.call(box.querySelectorAll('[role="tab"]'));
    function select(tab, focus) {
      tabs.forEach(function (t) {
        var on = t === tab;
        t.setAttribute('aria-selected', on ? 'true' : 'false'); t.tabIndex = on ? 0 : -1;
        var p = d.getElementById(t.getAttribute('aria-controls')); if (p) p.hidden = !on;
      });
      if (focus) tab.focus();
      if (tab.scrollIntoView && tab.parentNode.scrollWidth > tab.parentNode.clientWidth) tab.parentNode.scrollTo({ left: tab.offsetLeft - 20, behavior: 'smooth' });
    }
    tabs.forEach(function (t, i) {
      t.addEventListener('click', function () { select(t); });
      t.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowRight') select(tabs[(i + 1) % tabs.length], true);
        if (e.key === 'ArrowLeft') select(tabs[(i - 1 + tabs.length) % tabs.length], true);
      });
    });
  });

  /* ---- doctors carousel ---- */
  var car = d.querySelector('[data-nent-carousel]');
  if (car) {
    var step = function () { var c = car.querySelector('.nent-doc'); return c ? c.getBoundingClientRect().width + 20 : 300; };
    var prev = d.querySelector('[data-nent-prev]'), next = d.querySelector('[data-nent-next]');
    if (prev) prev.addEventListener('click', function () { car.scrollBy({ left: -step(), behavior: 'smooth' }); });
    if (next) next.addEventListener('click', function () { car.scrollBy({ left: step(), behavior: 'smooth' }); });
    car.setAttribute('data-lenis-prevent-horizontal', '');
  }

  onScroll();
})();
