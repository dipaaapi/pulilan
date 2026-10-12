"""Create a private recovery archive containing the live SQL dump and uploads."""
from datetime import datetime
from hashlib import sha256
from pathlib import Path
import json
import subprocess
from zipfile import ZipFile, ZIP_DEFLATED

root = Path(__file__).resolve().parents[1]
directory = root / 'storage' / 'backups'
directory.mkdir(parents=True, exist_ok=True)
stamp = datetime.now().strftime('%Y%m%d-%H%M%S-%f')
target = directory / f'recovery-{stamp}.zip'
temporary = target.with_suffix('.partial')
dump = subprocess.run(['docker','compose','exec','-T','db','mysqldump','-uroot',
                       '--single-transaction','--skip-lock-tables','--hex-blob','pulilan'],
                      cwd=root, check=True, capture_output=True).stdout
if not dump or b'CREATE TABLE' not in dump:
    raise RuntimeError('Database dump is empty or incomplete.')
manifest = {'created': datetime.now().astimezone().isoformat(), 'database': 'pulilan',
            'files': {'database.sql': sha256(dump).hexdigest()}}
try:
    with ZipFile(temporary, 'x', ZIP_DEFLATED) as archive:
        archive.writestr('database.sql', dump)
        for path in sorted((root / 'storage' / 'uploads').glob('*')):
            if path.is_file() and not path.is_symlink() and path.name != '.gitkeep':
                path.resolve().relative_to((root / 'storage' / 'uploads').resolve())
                data = path.read_bytes()
                name = 'uploads/' + path.name
                archive.writestr(name, data)
                manifest['files'][name] = sha256(data).hexdigest()
        archive.writestr('manifest.json', json.dumps(manifest, indent=2))
    with ZipFile(temporary) as archive:
        if archive.testzip() is not None:
            raise RuntimeError('Recovery archive verification failed.')
        for name, digest in manifest['files'].items():
            if sha256(archive.read(name)).hexdigest() != digest:
                raise RuntimeError('Recovery archive checksum mismatch.')
    temporary.rename(target)
except BaseException:
    if temporary.exists(): temporary.unlink()
    raise
print('Verified recovery archive:', target)
