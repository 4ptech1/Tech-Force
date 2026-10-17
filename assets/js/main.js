/* Tech Force Consulting Engineers — site behaviour (no dependencies) */
(function () {
  'use strict';

  // ---------- Footer year ----------
  document.querySelectorAll('[data-year]').forEach(function (el) {
    el.textContent = new Date().getFullYear();
  });

  // ---------- Slim header (smaller logo, shadow) once the page scrolls ----------
  var header = document.querySelector('[data-header]');
  if (header) {
    var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 24); };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  // ---------- Mobile navigation ----------
  var toggle = document.querySelector('[data-nav-toggle]');
  var nav = document.querySelector('[data-nav]');
  if (toggle && nav) {
    var setOpen = function (open) {
      toggle.setAttribute('aria-expanded', String(open));
      nav.classList.toggle('is-open', open);
    };
    toggle.addEventListener('click', function () {
      setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });
    nav.addEventListener('click', function (e) {
      if (e.target.closest('a')) setOpen(false);
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) { setOpen(false); toggle.focus(); }
    });
    window.matchMedia('(min-width: 821px)').addEventListener('change', function (mq) {
      if (mq.matches) setOpen(false);
    });
  }

  // ---------- RFQ form ----------
  var form = document.querySelector('[data-rfq-form]');
  if (!form) return;

  var statusBox = form.querySelector('[data-form-status]');
  var submitBtn = form.querySelector('[data-submit]');
  var SUCCESS = 'Thank you — your request has been sent. Our engineers will be in touch shortly.';
  var GENERIC_ERROR = 'Sorry, your request could not be sent. Please try again or email info@techforceconsulting.com.';

  function showStatus(type, message) {
    statusBox.className = 'form-status is-' + type;
    statusBox.textContent = message;
  }

  // Pre-fill the "service" / "sector" dropdowns from a query string such as ?sector=railways
  function preselect(query) {
    var params = new URLSearchParams(query);
    ['service', 'sector'].forEach(function (name) {
      var select = form.querySelector('[name="' + name + '"]');
      var value = params.get(name);
      if (!select || !value) return;
      var exists = Array.prototype.some.call(select.options, function (o) { return o.value === value; });
      if (exists) select.value = value;
    });
  }

  // In-page "Discuss …" buttons link to ?service=xyz#contact — preselect without a page reload.
  document.querySelectorAll('a[href^="?service="], a[href^="?sector="]').forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      preselect(link.getAttribute('href').split('#')[0]);
      document.getElementById('contact').scrollIntoView();
      form.querySelector('[name="name"]').focus({ preventScroll: true });
    });
  });

  // Arrivals from the home page's sector cards, shared links, or the no-JS PHP redirect.
  var params = new URLSearchParams(window.location.search);
  preselect(window.location.search);
  if (params.get('status') === 'sent') {
    showStatus('success', SUCCESS);
  } else if (params.get('status') === 'error') {
    showStatus('error', GENERIC_ERROR);
  }

  // Highlight invalid fields only after a submit attempt.
  form.addEventListener('invalid', function () { form.classList.add('was-validated'); }, true);

  // Submit in the background so the visitor stays on the page.
  form.addEventListener('submit', function (e) {
    if (!window.fetch || !window.FormData) return; // very old browser: normal POST + redirect
    e.preventDefault();

    var label = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Sending…';
    statusBox.className = 'form-status';

    fetch(form.action, {
      method: 'POST',
      body: new FormData(form),
      headers: { Accept: 'application/json' }
    })
      .then(function (res) {
        return res.json().catch(function () { return {}; });
      })
      .then(function (data) {
        if (data.ok) {
          form.reset();
          form.classList.remove('was-validated');
          showStatus('success', SUCCESS);
        } else {
          // Server-side validation messages are safe to show; anything else gets the generic text.
          showStatus('error', data.message || GENERIC_ERROR);
        }
      })
      .catch(function () { showStatus('error', GENERIC_ERROR); })
      .then(function () {
        submitBtn.disabled = false;
        submitBtn.innerHTML = label;
      });
  });
})();
