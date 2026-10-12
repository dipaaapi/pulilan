'use strict';

(() => {
  const dialog = document.getElementById('document-preview');
  if (!dialog) return;
  const frame = dialog.querySelector('[data-pdf-frame]');
  let previousFocus = null;
  document.querySelectorAll('[data-pdf-view]').forEach(link => link.addEventListener('click', event => {
    event.preventDefault();
    previousFocus = link;
    const title = link.dataset.pdfTitle;
    document.getElementById('document-preview-title').textContent = title;
    frame.title = `${title} - PDF preview`;
    frame.src = link.href;
    dialog.querySelector('[data-pdf-open]').href = link.href;
    dialog.querySelector('[data-pdf-download]').href = link.href;
    dialog.showModal();
    dialog.querySelector('[data-pdf-close]').focus();
  }));
  dialog.querySelector('[data-pdf-close]').addEventListener('click', () => dialog.close());
  dialog.addEventListener('close', () => {
    frame.removeAttribute('src');
    previousFocus?.focus({preventScroll: true});
  });
  dialog.addEventListener('click', event => {
    const rect = dialog.getBoundingClientRect();
    if (event.target === dialog && (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom)) dialog.close();
  });
  const switches = [...document.querySelectorAll('[data-document-view]')];
  document.querySelector('[data-document-switch]').hidden = false;
  switches.forEach(button => button.addEventListener('click', () => {
    const cards = button.dataset.documentView === 'cards';
    document.getElementById('documents-table').hidden = cards;
    document.getElementById('documents-cards').hidden = !cards;
    switches.forEach(control => control.setAttribute('aria-pressed', String(control === button)));
  }));
})();
