'use strict';

(() => {
  const panel = document.getElementById('accessibility-options');
  if (!panel) return;
  const opener = document.querySelector('[data-help-open]');
  let returnFocus = null;
  let destination = null;
  const tabs = [...panel.querySelectorAll('[data-help-tab]')];
  const selectTab = selected => {
    tabs.forEach(tab => {
      const active = tab === selected;
      tab.setAttribute('aria-selected', String(active));
      tab.tabIndex = active ? 0 : -1;
      document.getElementById(tab.dataset.helpTab).hidden = !active;
    });
    panel.scrollTop = 0;
  };
  tabs.forEach((tab, index) => {
    tab.addEventListener('click', () => selectTab(tab));
    tab.addEventListener('keydown', event => {
      let next;
      if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
      if (event.key === 'ArrowLeft') next = (index + tabs.length - 1) % tabs.length;
      if (event.key === 'Home') next = 0;
      if (event.key === 'End') next = tabs.length - 1;
      if (next !== undefined) { event.preventDefault(); selectTab(tabs[next]); tabs[next].focus(); }
    });
  });
  opener.addEventListener('click', event => {
    event.preventDefault();
    returnFocus = document.activeElement;
    destination = null;
    panel.showModal();
    panel.querySelector('[data-help-close]').focus();
  });
  panel.querySelector('[data-help-close]').addEventListener('click', () => panel.close());
  panel.addEventListener('close', () => {
    if (destination) {
      destination.focus({preventScroll: true});
      destination.scrollIntoView({behavior: 'instant', block: 'start'});
    } else returnFocus?.focus({preventScroll: true});
    destination = null;
  });
  panel.addEventListener('click', event => {
    const rect = panel.getBoundingClientRect();
    if (event.target === panel && (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom)) panel.close();
  });
  const root = document.documentElement;
  const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
  const defaults = {size: '100', theme: 'default', grayscale: false, hideImages: false, readable: false, spacing: false, links: false, reduceMotion: false, smooth: false};
  const key = 'pulilan-accessibility-v1';
  let preferences = {...defaults};
  try {
    const saved = JSON.parse(localStorage.getItem(key));
    if (saved && typeof saved === 'object') {
      for (const name of Object.keys(defaults)) {
        if (typeof defaults[name] === 'boolean' && typeof saved[name] === 'boolean') preferences[name] = saved[name];
      }
      if (['100','125','150','200'].includes(saved.size)) preferences.size = saved.size;
      if (['default','dark','contrast'].includes(saved.theme)) preferences.theme = saved.theme;
    }
  } catch { /* Storage may be unavailable; controls still work in this page. */ }
  const controls = [...panel.querySelectorAll('[data-a11y]')];
  const apply = () => {
    root.dataset.textSize = preferences.size;
    root.dataset.theme = preferences.theme;
    for (const name of ['grayscale','hideImages','readable','spacing','links']) root.classList.toggle(`a11y-${name}`, preferences[name]);
    const reduced = motion.matches || preferences.reduceMotion;
    root.classList.toggle('a11y-reduceMotion', reduced);
    root.classList.toggle('a11y-smooth', preferences.smooth && !reduced);
    for (const control of controls) {
      const name = control.dataset.a11y;
      if (control.type === 'checkbox') control.checked = preferences[name];
      else control.value = preferences[name];
      if (name === 'smooth') { control.disabled = reduced; control.checked = preferences.smooth && !reduced; }
    }
  };
  const save = () => { try { localStorage.setItem(key, JSON.stringify(preferences)); } catch {} };
  for (const control of controls) control.addEventListener('change', () => {
    preferences[control.dataset.a11y] = control.type === 'checkbox' ? control.checked : control.value;
    apply(); save();
    panel.querySelector('[data-a11y-status]').textContent = 'Accessibility preference applied.';
  });
  panel.querySelector('[data-a11y-reset]').addEventListener('click', () => {
    preferences = {...defaults}; apply(); save();
    panel.querySelector('[data-a11y-status]').textContent = 'Preferences reset. Device motion preferences still apply.';
  });
  motion.addEventListener('change', apply);
  let scrollFrame = null;
  const stopScrollAnimation = () => {
    if (scrollFrame !== null) cancelAnimationFrame(scrollFrame);
    scrollFrame = null;
  };
  window.addEventListener('wheel', stopScrollAnimation, {passive: true});
  window.addEventListener('touchstart', stopScrollAnimation, {passive: true});
  window.addEventListener('keydown', event => {
    if (['ArrowUp','ArrowDown','PageUp','PageDown','Home','End',' '].includes(event.key)) stopScrollAnimation();
  });
  document.querySelector('[data-back-to-top]')?.addEventListener('click', event => {
    event.preventDefault();
    stopScrollAnimation();
    document.getElementById('page-top').focus({preventScroll: true});
    if (motion.matches || preferences.reduceMotion) {
      window.scrollTo({top: 0, behavior: 'instant'});
      return;
    }
    const start = window.scrollY;
    const duration = Math.min(1000, Math.max(450, start * .25));
    const started = performance.now();
    const animate = now => {
      if (motion.matches || preferences.reduceMotion) {
        scrollFrame = null;
        window.scrollTo({top: 0, behavior: 'instant'});
        return;
      }
      const progress = Math.min(1, (now - started) / duration);
      // Cubic ease-in-out: accelerate gently, then decelerate toward the top.
      const eased = progress < .5 ? 4 * progress ** 3 : 1 - (-2 * progress + 2) ** 3 / 2;
      window.scrollTo({top: start * (1 - eased), behavior: 'instant'});
      scrollFrame = progress < 1 ? requestAnimationFrame(animate) : null;
    };
    scrollFrame = requestAnimationFrame(animate);
  });
  panel.querySelectorAll('[data-help-jump]').forEach(link => link.addEventListener('click', event => {
    event.preventDefault();
    destination = document.querySelector(link.getAttribute('href'));
    panel.close();
  }));
  apply();
  if (location.hash === '#message-us') {
    opener.click();
    selectTab(tabs.find(tab => tab.dataset.helpTab === 'help-message'));
    document.getElementById('contact-name').focus();
  }
})();
