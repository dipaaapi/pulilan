"""Preserve the working tree and database before reorganizing the application."""
from pathlib import Path
import shutil
import subprocess
from datetime import datetime

root = Path(__file__).resolve().parents[1]
backup = root / 'storage' / 'backups'
backup.mkdir(parents=True, exist_ok=True)
snapshot = backup / ('before-upgrade-' + datetime.now().strftime('%Y%m%d-%H%M%S') + '.sql')
if not (root / 'legacy').exists():
    result = subprocess.run(['docker', 'compose', 'exec', '-T', 'db', 'mysqldump', '-uroot', '--single-transaction', '--skip-lock-tables', 'pulilan'], cwd=root, capture_output=True, check=True)
    snapshot.write_bytes(result.stdout)
    (root / 'database').mkdir(exist_ok=True)
    shutil.copy2(root / 'pulilan.sql', root / 'database' / 'schema.sql')
    (root / 'public' / 'assets' / 'images').mkdir(parents=True, exist_ok=True)
    shutil.copytree(root / 'img', root / 'public' / 'assets' / 'images', dirs_exist_ok=True)
    legacy = root / 'legacy'
    legacy.mkdir()
    keep = {'.git', '.vscode', 'legacy', 'public', 'app', 'views', 'database', 'docs', 'tests', 'storage', 'tools', 'Dockerfile', 'compose.yaml', '.dockerignore', 'README.docker.md', '.gitignore', '.env', '.env.example'}
    for source in list(root.iterdir()):
        if source.name in keep:
            continue
        target = legacy / source.name
        # Verify both absolute paths before moving directories on Windows.
        if not source.resolve().is_relative_to(root) or not target.resolve().is_relative_to(legacy):
            raise RuntimeError('Move outside workspace refused')
        shutil.move(str(source), str(target))
    print('Database backup:', snapshot)
    print('Original source preserved in:', legacy)
else:
    print('Legacy source already preserved; no files moved.')
