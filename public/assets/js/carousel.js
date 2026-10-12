'use strict';

// Image-only carousel: outgoing image moves left, next image enters from the right.
document.querySelectorAll('[data-carousel]').forEach(carousel => {
  const slides = [...carousel.querySelectorAll('[data-carousel-slide]')];
  if (slides.length < 2) return;
  const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
  let index = 0, timer = null, hovered = false, visible = true, animating = false;
  let animations = [];
  const reduced = () => motion.matches || document.documentElement.classList.contains('a11y-reduceMotion');
  const blocked = () => animating || hovered || document.hidden || !visible || reduced() || !!document.querySelector('dialog:modal') || document.documentElement.classList.contains('a11y-hideImages');
  const advance = async () => {
    if (blocked()) return;
    animating = true;
    const current = slides[index];
    const nextIndex = (index + 1) % slides.length;
    const next = slides[nextIndex];
    next.hidden = false;
    if (typeof next.animate === 'function') {
      const options = {duration: 700, easing: 'ease-in-out', fill: 'forwards'};
      animations = [
        current.animate([{transform: 'translateX(0)'}, {transform: 'translateX(-100%)'}], options),
        next.animate([{transform: 'translateX(100%)'}, {transform: 'translateX(0)'}], options)
      ];
      await Promise.allSettled(animations.map(animation => animation.finished));
    }
    current.hidden = true;
    animations.forEach(animation => animation.cancel());
    animations = [];
    index = nextIndex;
    animating = false;
    schedule();
  };
  const schedule = () => {
    clearTimeout(timer);
    if (reduced()) animations.forEach(animation => animation.cancel());
    if (!blocked()) timer = setTimeout(advance, 6000);
  };
  carousel.addEventListener('mouseenter', () => { hovered = true; schedule(); });
  carousel.addEventListener('mouseleave', () => { hovered = false; schedule(); });
  document.addEventListener('visibilitychange', schedule);
  motion.addEventListener('change', schedule);
  new MutationObserver(schedule).observe(document.documentElement, {attributes: true, attributeFilter: ['class']});
  document.querySelectorAll('dialog').forEach(dialog => new MutationObserver(schedule).observe(dialog, {attributes: true, attributeFilter: ['open']}));
  if ('IntersectionObserver' in window) new IntersectionObserver(entries => { visible = entries[0].isIntersecting; schedule(); }).observe(carousel);
  schedule();
});
