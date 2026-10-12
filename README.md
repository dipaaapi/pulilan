# Pulilan Community-Based Monitoring System

A modernized municipal portal written in native PHP, CSS, and JavaScript.
No application framework, frontend library, Composer package, or npm package
is needed at runtime. Docker provides PHP 8.5, Apache, and the existing MySQL database.

Bootstrap, Font Awesome, and Materialize assets have also been removed from the
local legacy archive. The live interface uses shared native controls, CSS states,
and a native confirmation dialog; it has no SweetAlert dependency. Archived PHP
pages retain their historical source and are not served by Docker.

## Start

```powershell
docker compose up -d --build
```

Open http://127.0.0.1:8080. Existing usernames and passwords are preserved;
passwords are converted to secure hashes during migration. New public accounts
are resident accounts awaiting administrator approval.

## Find a feature

| Location | Responsibility |
| --- | --- |
| `public/index.php` | Web entry point and route dispatch |
| `app/controllers/auth.php` | Sign-in and resident registration |
| `app/controllers/actions.php` | Validated record changes, profile updates, reviews, replies |
| `app/controllers/pages.php` | Page loading, protected downloads, CSV exports |
| `app/resources.php` | Resource definitions, permissions, field rules, record scopes |
| `app/security.php` | Sessions, CSRF, persistent sign-in, throttling, audit helpers |
| `app/database.php` | PDO connection and database helpers |
| `app/content/municipality.php` | Curated official municipal information and source links |
| `app/content/faq.php` | Citizen FAQs shown in the global Accessibility & Help modal |
| `app/content/official-assets.json` | Source URLs, dates, sizes, and hashes of copied official assets |
| `views/layouts/` | Shared header, navigation, sidebar, footer, confirmation dialog |
| `views/components/ui.php` | Reusable buttons, fields, checkboxes, badges, forms |
| `views/pages/` | Home, auth, overview, records, editor, details, reports, history, profile |
| `public/assets/css/` | Global foundation, shared controls, page-specific styles |
| `public/assets/js/app.js` | Native UI enhancements |
| `public/documents/official/` | Selected municipal charters and blank application forms |
| `database/` | Preserved schema and idempotent migrations |
| `docs/` | Architecture, components, permissions, migration guidance |
| `tests/` | Isolated integration and security/component verification |
| `tools/` | Startup, preview, lint, preservation, attachment import |
| `storage/` | Private uploads, backups, and preview files; excluded from Git |
| `storage/backups/legacy.zip` | Verified archive of the remaining legacy source; excluded from Git and Docker images |

## Legacy archive

The `legacy/` folder has been removed. Its remaining 245 files are preserved in
`storage/backups/legacy.zip`, with the original directory structure. Every file
was verified by SHA-256 against the source before removing the folder.
Previously removed vendor libraries are not included in this archive.

The ZIP is for historical reference and recovery; the running application uses
`app/`, `views/`, and `public/`. Existing imported attachments remain in private
upload storage. Extract the archive into a separate directory if you need to
inspect old code. Keep it private because legacy source may contain credentials
and personal data.

See [Docker instructions](README.docker.md) and [architecture](docs/ARCHITECTURE.md).
See [official asset sources](docs/OFFICIAL-ASSETS.md) for copied PDFs, municipal
branding, and their intended uses. The homepage offers local reference downloads.
The [project Citizen Charter](docs/PROJECT-CHARTER.md) is a seven-page citizen guide
with browser viewing at `index.php?page=citizen-charter` and a PDF download.
