# Preservation, verification, and rollback

## Preserved data and source

Before reorganization, `tools/prepare_upgrade.py` exported the running database
to `storage/backups/before-upgrade-*.sql`. It moved the original working-tree
contents, including existing uncommitted modifications, into `legacy/`.
The Git directory and VS Code settings stayed in place. The original schema
is also preserved as `database/schema.sql`. No Git commit, reset, or push was
performed. The old archive and database backups are intentionally excluded from
Git and Docker images because they can contain historical credentials or data.

The live `mysql_data` volume remains intact. Do not run `docker compose down -v`
unless you intentionally want to discard the local database.

## Idempotent migrations

`database/migrate.php` records applied versions in `app_migrations`:

1. `001_native_app`: account access flag; missing memo remarks/creator columns;
   tokens, archives, audit, files, read status, and rate-limit tables; hash existing
   nonempty passwords in all three legacy account/profile tables. Existing
   visibility-based archives are carried forward.
2. `002_optional_voting_date`: allow a blank last-voted date, rather than inventing
   a voting date for someone who has not voted.
3. `003_unique_usernames`: database-enforced account username uniqueness.
   Migration stops if duplicates require manual reconciliation.
4. `004_session_revocation`: invalidate previous sessions after password/access changes.
5. `005_metadata_collations`: use the same collation for new metadata tables
   and legacy record joins, independent of the database's default collation.

Migrations run before Apache starts. Plaintext passwords are not retained in
the active database. Existing credentials still verify against the resulting
hashes. Blank historical usernames/passwords cannot authenticate.
Password conversion explicitly preserves legacy automatic-update timestamps.
The first live conversion exposed those automatic timestamp updates; they were
restored from the fresh pre-cutover dump without restoring plaintext passwords.

## Review environment

`python tools/preview.py` creates the isolated `pulilan_upgrade_test` database
from the pre-upgrade backup and starts `pulilan-preview` on port 8081. It does
not overwrite the live database. Preview attachments use a separate
`storage/preview-uploads` directory. HTTP tests have a hard guard requiring the
preview database before creating or removing fixtures. The test suite covers
roles, ownership scope, registration approval, CSRF, output escaping, memo
review, attachments, CSV exports, archives, password changes, and session/token
revocation. `tests/domain.php` checks validation, escaping, CSV protection,
component states, and legacy route consolidation.

Run the tests using the commands in `README.docker.md`. Never point disposable
fixtures at the live database. The preview remains a development service and
is not a public deployment.

## Legacy URLs

`app/routes.php` maps old read-only bookmarks to consolidated screens. The
legacy role dashboard links now resolve to one scoped dashboard. Old mutation
URLs are retired; actions use POST forms with CSRF validation. The historical
source directory itself is blocked by the public rewrite rules.

## Rollback

Stop the upgraded web service before rollback. Use a separate MySQL database or
volume and import the pre-upgrade SQL backup there, then serve the original
`legacy/` tree with its previous PHP runtime and connection configuration.
The old login code cannot authenticate against newly hashed passwords, so
serving legacy files against the upgraded database is not a complete rollback.
Keep the upgraded database intact until all new writes have been reconciled.

The legacy tree is a local recovery snapshot, not a recommended public runtime.
Its historical SMTP credentials must be rotated before any email integration
is restored. The upgraded application does not use those credentials.
