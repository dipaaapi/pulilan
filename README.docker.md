# Run with Docker

Start Docker Desktop, then run from this directory:

```powershell
docker compose up -d --build
```

Open http://localhost:8080.

Fresh installations include public barangay reference data, without private
account or survey seeds. Create the first administrator using the CLI tool:

```powershell
docker compose exec -e ADMIN_USERNAME=your_admin -e ADMIN_PASSWORD=your_unique_password web php tools/create-admin.php
```

Choose a unique password of 12-72 bytes; the tool stores a hash and never
overwrites an existing account. Existing Docker database volumes are unchanged.

PHP 8.5 runs in Apache with `public/` as the document root. MySQL imports
`database/schema.sql` on the first startup. Versioned application migrations
run automatically before Apache starts, including hashing existing passwords.
Source files are mounted into the web container, so edits appear immediately.
The source mount is read-only inside Docker; only private uploads are writable.
Web requests use a restricted SQL account provisioned during startup.
The application uses native PDO prepared statements through a shared MySQL socket.
Database data persists in the `mysql_data` Docker volume.

```powershell
docker compose ps
docker compose logs --tail=100
docker compose down
```

`docker compose down` stops the app and preserves database data.
The database uses an empty root password to match the existing PHP code and
is intended for local development only. MySQL has no published network port;
the web port is bound to this computer's loopback interface.

See [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md) for the file map,
[docs/COMPONENTS.md](docs/COMPONENTS.md) for UI components, and
[docs/MIGRATION.md](docs/MIGRATION.md) for preservation and rollback details.

## Isolated verification

```powershell
python tools/preview.py
docker exec pulilan-preview php tools/lint.php
docker exec pulilan-preview php tests/domain.php
python tests/http_smoke.py
node --check public/assets/js/app.js
```

The preview is at http://localhost:8081 and uses `pulilan_upgrade_test` rather
than the live database. Tests create and remove disposable preview fixtures.
After rebuilding the image, run `python tools/preview.py --recreate` to replace
only the preview container; its database remains intact.

To stop the preview: `docker stop pulilan-preview`.

For a reviewed cutover of an existing checkout, `python tools/cutover.py` makes
a fresh live backup, records data fingerprints, rebuilds/starts the app, and
checks that the original records and password migration were preserved.

Run `python tools/backup.py` to create a verified SQL-and-uploads recovery archive.
See [security and recovery](docs/SECURITY-RECOVERY.md) for protections and limits.
