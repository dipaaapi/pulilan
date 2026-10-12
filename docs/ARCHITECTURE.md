# Architecture and feature map

## Request flow

`public/index.php` loads the bootstrap, resolves an allowlisted page, invokes a
controller, then renders a page inside the shared layout. Database operations
use native PDO prepared statements. Table and column identifiers come from
resource definitions or database metadata, never user-supplied SQL fragments.

Each resource defines its table, key, editable fields, list columns, read roles,
and write roles in `app/resources.php`. One list, editor, and detail template
serve resources with the same behavior. Memo review and message reply panels
remain specific to their own workflows. Authentication and public contact forms
have their own controllers and validation.

## Consolidated features

| Previous screens | Current screen |
| --- | --- |
| Admin, executive, DILG, official, and resident dashboards | Overview; navigation and data depend on the role |
| Multiple login and registration layouts | Shared authentication layout |
| Account tables, activation, archived account screens | Accounts with enable/disable and archive/restore |
| Barangay-specific resident response pages | Resident surveys with server-enforced scope |
| Barangay questionnaires and answers | Barangay surveys with one editor and detail view |
| Admin, executive, DILG, and barangay memo lists | Memos with a shared review panel |
| Duplicate achievement pages and forms | Achievements |
| Repeated reports and final report views | Scoped reports, full CSV exports, browser printing |
| Contact and message histories | Public contact form and authenticated inbox |
| Repeated destructive-action modals | Shared native confirmation dialog |

Community profile records (`residentdetails_tbl`, `brgydetails_tbl`) remain
separate from sign-in accounts (`mainuser_acc`). Their IDs are not assumed to
identify the same person. Creating a profile does not silently create a login.
Resident surveys link explicitly to a resident's sign-in account. All original
survey columns are represented in the native editor.

## Roles

| Role | Main permissions |
| --- | --- |
| Administrator | Accounts, profiles, barangays, memos, achievements, surveys, inbox, archives, audit history |
| DILG | Read municipal surveys and reports, review memos, maintain achievements, own inbox |
| Executive | Read municipal surveys and reports, create/edit memos, own inbox |
| Barangay official | Maintain resident profiles and surveys in the assigned barangay; submit barangay surveys; read approved addressed memos |
| Resident | Own resident surveys and messages; approved addressed memos; achievements; own reports |

Permissions are checked on every read and mutation. Hiding a navigation item
is not the authorization mechanism. Officials cannot access another barangay's
resident data. Residents cannot select a different survey owner. Public signup
cannot request a privileged role. New sign-in accounts must be enabled by an
administrator. Existing account access is preserved by migration because the
legacy `activate` flag has inconsistent meanings across old handlers.

## Security and files

Mutations require POST and a session CSRF token. Password hashes use PHP's
password API. Authentication rotates the session ID. Persistent sign-in stores
only a validator hash and rotates credentials when reused. Password changes,
account disabling, role changes, and archiving invalidate previous sessions.
Login, signup, and public contact have persistent request limits.

Attachments are MIME-checked PDF/JPEG/PNG/WebP files, limited to 5 MB, assigned
random filenames, and stored outside the document root. Downloads authorize
the parent record. Missing legacy attachments are shown explicitly. Submitted
text is escaped at rendering time. CSV fields guard against spreadsheet formula
execution, and password hashes are excluded from exports.

Audit timestamps use Asia/Manila. Reports count submissions and distinguish
their summed household figures from deduplicated municipal population data.

## Runtime and hosting

Use `public/` as Apache's document root. App code, database dumps, backups, and
the local historical archive are not public assets. The root compatibility
entry point and rewrite rules support XAMPP checkouts; configure
`APP_BASE_PATH=/pulilan` if serving under that URL prefix. PHP needs `pdo_mysql`
and `fileinfo`; MySQLi is retained in the Docker image for migration compatibility.

The provided Compose file is for local development. For internet hosting,
configure HTTPS, database credentials with restricted application access,
persistent private upload storage, and managed backups. The repository does not
contain mail-service credentials. Public inquiries are saved locally; replies
to registered users are delivered to their inbox. External email delivery is
not configured.
