# Protection and recovery

Docker serves project source from a read-only mount. Only private uploads are
writable in the project tree. Web requests use a generated database account
without DROP, ALTER, CREATE, GRANT, FILE, or DELETE on original business tables.
Audit history permits SELECT and INSERT only. DELETE is limited to temporary
authentication/rate-limit entries and reversible archive markers. Credential
files live outside the document root, in `/run/pulilan`, with restricted access.
CLI migration and maintenance tools retain administrative access.

Authenticated writes are limited to 120 per account per five minutes; archive
and restore actions are limited to 20. Existing CSRF, role and record scope
checks, password hashing, private upload checks, and session revocation remain
in place. Archives preserve the original records for recovery.

## Create a recovery copy

Run `python tools/backup.py` before upgrades and regularly while using the app.
It creates a verified ZIP in `storage/backups` containing SQL, private uploads,
and a SHA-256 manifest. It does not automatically delete older backups.
Pause writes during backup for consistent SQL and attachment references; the
database snapshot and filesystem copy are not an atomic combined snapshot.

Copy recovery archives to a separate protected device or backup service. They
contain personal data and must not be published or committed. A backup on the
same computer cannot survive someone erasing that computer or Docker volumes.

## Incident response

1. Stop the web service with `docker compose stop web` to halt application writes.
2. Preserve container logs, the current database, uploads, and audit records.
3. Restore a verified recovery archive into an isolated database first. Import
   `database.sql` with the MySQL client and restore its uploads into private
   storage; verify accounts and survey counts before replacing live data.
4. Revoke compromised sessions and persistent tokens, reset affected passwords,
   fix the cause, and restart the web service to rotate its database credentials.

## Deployment boundary

This Compose setup remains local-only on 127.0.0.1. Its MySQL root account uses
the existing empty development password, and maintenance processes have root
access. Before public deployment, configure strong database administrator
credentials, HTTPS, external backups, and host-level access controls. Limited
web SQL privileges mitigate application SQL misuse; they do not protect against
a compromised host, Docker administrator, arbitrary server code execution, or
an authorized administrator deliberately changing records. These changes are
not a guarantee against every attack or a security certification.
