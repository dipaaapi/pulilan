# Accessibility controls

The global native dialog is rendered by `views/components/accessibility.php` from
the shared footer. A combined bottom-right toolbar provides Back to top and
Accessibility & Help. The dialog groups reading settings, a quick-start guide,
and twelve expandable FAQs maintained in `app/content/faq.php`. It also links to
the project Citizen Charter PDF viewer. Native enhancements live in `public/assets/js/accessibility.js`;
global preference overrides live in `public/assets/css/accessibility.css`.

Text size supports 100%, 125%, 150%, and 200%. Color modes are mutually exclusive:
default, dark, or high contrast. Other controls adjust grayscale, decorative
images, the system Arial font, spacing, link emphasis, and motion. No external
fonts, toolbar libraries, or disability-specific font claims are used.

Preferences are validated and saved under `pulilan-accessibility-v1` in browser
local storage. Blocked or corrupt storage falls back safely. Reset restores
defaults; operating-system reduced motion still applies. Smooth scrolling is
off by default. The panel scrolls within the viewport and supports native
keyboard controls, Escape and backdrop dismissal, focus return, and content/footer
links. Native `showModal()` keeps keyboard focus inside the open dialog; page
scrolling is locked globally through `html:has(dialog:modal)` in `global.css`.
This covers help, confirmation, and future native modals, and only unlocks when
the last modal closes. Modal content can still scroll. Without JavaScript, the toolbar help link
opens the Citizen Charter guide page.

## References reviewed October 13, 2026

- [CamSur](https://camsur.com/): source includes grayscale, dark mode, high contrast,
  text sizes, and an OpenDyslexic font option. Used as a feature reference.
- [DOST accessibility features](https://www.dost.gov.ph/accessibility-features.html):
  contrast controls, skip navigation, and keyboard guidance.
- [NCDA accessibility statement](https://ncda.gov.ph/accessibility-statement/):
  accessibility toolbar and font choices described for its online courses.

These controls supplement semantic markup, labels, focus indicators, and
keyboard navigation. They do not constitute a WCAG compliance certification.
Interactive browser and assistive-technology review is still needed; no browser
was connected during implementation.
