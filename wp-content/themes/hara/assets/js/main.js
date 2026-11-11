/* HaRa Foods theme — small, dependency-free enhancements. */
(function () {
	'use strict';

	var toggle = document.querySelector('.hara-nav-toggle');
	var nav = document.getElementById('hara-nav');
	var body = document.body;

	function setOpen(open) {
		if (!toggle) return;
		var hdr = document.querySelector('.hara-header');
		if (open && hdr) document.documentElement.style.setProperty('--hara-header-h', Math.round(hdr.getBoundingClientRect().bottom) + 'px');
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		body.classList.toggle('hara-nav-open', open);
	}

	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			setOpen(toggle.getAttribute('aria-expanded') !== 'true');
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && body.classList.contains('hara-nav-open')) {
				setOpen(false);
				toggle.focus();
			}
		});
		nav.addEventListener('click', function (e) {
			if (e.target.closest('a')) setOpen(false);
		});
		window.matchMedia('(min-width: 960px)').addEventListener('change', function (mq) {
			if (mq.matches) setOpen(false);
		});
	}

	// Subtle shadow on the sticky header once the page scrolls.
	var header = document.querySelector('.hara-header');
	if (header) {
		var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 8); };
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	// Fade sections in as they enter the viewport (skipped for reduced-motion users).
	if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
		var items = document.querySelectorAll('.hara-reveal');
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					io.unobserve(entry.target);
				}
			});
		}, { rootMargin: '0px 0px -10% 0px' });
		items.forEach(function (el) { el.classList.add('will-reveal'); io.observe(el); });
	}
})();
