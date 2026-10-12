# Shared UI components and CSS

## Stylesheet responsibilities

- `public/assets/css/global.css`: design tokens, reset, typography, spacing,
  shared layout utilities, header/footer, responsive foundations, reduced
  motion, and printing.
- `public/assets/css/components.css`: controls, tables, cards, alerts, dropdowns,
  confirmation dialog, and interaction states.
- `public/assets/css/pages/landing.css`: home-specific hero and content sections.
- `public/assets/css/pages/auth.css`: shared sign-in/registration layout.
- `public/assets/css/pages/portal.css`: workspace sidebar, editor/detail/report layouts.

Load the global and component styles first, then exactly one page stylesheet.
Put a repeated rule in the shared component stylesheet rather than copying it
into each page. Change tokens to update colors, borders, spacing, or typography
across the application. Avoid inline styles and scripts; the CSP disallows them.

## PHP component examples

Components live in `views/components/ui.php` and are loaded by the bootstrap.
Labels, values, URLs, and attributes are escaped by the helpers.

```php
echo button('Save record');
echo button('Cancel', ['href' => url('dashboard'), 'variant' => 'secondary']);
echo button('Unavailable', ['type' => 'button', 'disabled' => true]);
echo field('name', 'Full name', $name, ['required' => true, 'maxlength' => 80]);
echo field('message', 'Message', '', ['type' => 'textarea', 'maxlength' => 10000]);
echo field('status', 'Status', 'pending', [
    'type' => 'select',
    'options' => ['pending' => 'Pending', 'approved' => 'Approved'],
]);
echo field('email', 'Email', $email, [
    'type' => 'email', 'error' => 'Enter a valid email address.',
]);
echo checkbox('remember_me', 'Keep me signed in');
echo badge('Pending');
echo action_form('archive', 'accounts', $id, 'Archive', 'danger', true);
```

## Interaction states

Buttons have hover, keyboard focus, pressed, disabled, and loading states.
Persistent pressed state uses `aria-pressed`, as in the password visibility
toggle. Fields have hover/focus, disabled/read-only, required, and invalid
states with accessible descriptions. Native checkboxes and selects retain
their browser keyboard and selected-state behavior. Navigation uses
`aria-current` for the active destination. Dropdowns use native `details` and
`summary`, with styling for the open state, outside-click closing, and Escape.

The shared native `dialog` traps keyboard focus while open, initially focuses
Cancel, supports Escape and backdrop closing, and restores the original focus.
Archive/restore forms invoke it through `data-confirm`; without JavaScript,
the server-authorized POST still works and archiving remains reversible.

Forms marked `data-submit` show loading state and prevent repeat submissions.
The state resets after browser back navigation. Landing search uses `data-filter`
with an accessible result count. The workspace menu collapses on narrow screens.
Shared behavior lives in `public/assets/js/app.js`, with no external dependencies.
