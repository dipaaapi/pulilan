'use strict';

// Shared progressive enhancements. All forms and navigation also work without JS.
document.querySelectorAll('[data-password]').forEach(button => {
  button.addEventListener('click', () => {
    const input = document.getElementById(button.dataset.password);
    const showing = input.type === 'password';
    input.type = showing ? 'text' : 'password';
    button.setAttribute('aria-pressed', String(showing));
    button.textContent = showing ? 'Hide password' : 'Show password';
  });
});

document.querySelectorAll('[data-filter]').forEach(input => {
  input.addEventListener('input', () => {
    const grid = document.getElementById(input.dataset.filter);
    const search = input.value.trim().toLocaleLowerCase();
    let count = 0;
    grid.querySelectorAll('[data-search]').forEach(item => {
      item.hidden = !item.dataset.search.includes(search);
      if (!item.hidden) count += 1;
    });
    document.getElementById('barangay-count').textContent = `${count} profiles`;
    document.getElementById('filter-empty').hidden = count !== 0;
  });
});

const dialog = document.getElementById('confirmation');
let pendingForm = null;
let previousFocus = null;
document.querySelectorAll('form[data-confirm]').forEach(form => {
  form.addEventListener('submit', event => {
    if (form.dataset.confirmed === 'true') return;
    event.preventDefault();
    pendingForm = form;
    previousFocus = document.activeElement;
    document.getElementById('confirmation-description').textContent = form.dataset.confirm;
    dialog.showModal();
    dialog.querySelector('[data-dialog-cancel]').focus();
  });
});
dialog.querySelector('[data-dialog-cancel]').addEventListener('click', () => dialog.close());
dialog.querySelector('[data-dialog-confirm]').addEventListener('click', () => {
  const form = pendingForm;
  dialog.close();
  if (form) { form.dataset.confirmed = 'true'; form.requestSubmit(); }
});
dialog.addEventListener('close', () => { pendingForm = null; previousFocus?.focus(); });
dialog.addEventListener('click', event => {
  const rect = dialog.getBoundingClientRect();
  if (event.target === dialog && (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom)) dialog.close();
});

document.querySelectorAll('form[data-submit]').forEach(form => {
  form.addEventListener('submit', () => {
    if (!form.checkValidity()) return;
    const button = form.querySelector('button[type="submit"]');
    if (button) { button.disabled = true; button.setAttribute('aria-busy','true'); }
  });
});
window.addEventListener('pageshow', () => {
  document.querySelectorAll('button[aria-busy="true"]').forEach(button => {
    button.disabled = false;
    button.removeAttribute('aria-busy');
  });
});
document.querySelectorAll('[data-print]').forEach(button => button.addEventListener('click', () => window.print()));

document.querySelectorAll('.dropdown').forEach(dropdown => {
  dropdown.addEventListener('toggle', () => {
    if (dropdown.open) document.querySelectorAll('.dropdown').forEach(other => { if (other !== dropdown) other.open = false; });
  });
});
document.addEventListener('click', event => {
  document.querySelectorAll('.dropdown[open]').forEach(dropdown => { if (!dropdown.contains(event.target)) dropdown.open = false; });
});
document.addEventListener('keydown', event => {
  if (event.key === 'Escape') document.querySelectorAll('.dropdown[open]').forEach(dropdown => { dropdown.open = false; dropdown.querySelector('summary').focus(); });
});
const menu = document.querySelector('.portal-menu');
if (menu) {
  const media = window.matchMedia('(max-width: 750px)');
  const adjust = () => { menu.open = !media.matches; };
  adjust(); media.addEventListener('change', adjust);
}
