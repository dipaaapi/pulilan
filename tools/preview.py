"""Start a review environment with a separate copy of the database."""
from pathlib import Path
import subprocess
import sys
import shutil

root = Path(__file__).resolve().parents[1]
def run(args, **kwargs):
    return subprocess.run(args, cwd=root, check=True, **kwargs)

name = 'pulilan_upgrade_test'
run(['docker','compose','exec','-T','db','mysql','-uroot','-e',f'CREATE DATABASE IF NOT EXISTS `{name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'])
table_count = run(['docker','compose','exec','-T','db','mysql','-uroot','-N','-e',f"SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='{name}'"], capture_output=True).stdout.strip()
if table_count == b'0':
    snapshot = sorted((root/'storage'/'backups').glob('before-upgrade-*.sql'))[-1].read_bytes()
    run(['docker','compose','exec','-T','db','mysql','-uroot',name], input=snapshot)
exists = subprocess.run(['docker','inspect','pulilan-preview'],cwd=root,capture_output=True)
if exists.returncode == 0 and '--recreate' in sys.argv:
    run(['docker','stop','pulilan-preview'],capture_output=True)
    run(['docker','rm','pulilan-preview'],capture_output=True)
    exists = subprocess.run(['docker','inspect','pulilan-preview'],cwd=root,capture_output=True)
if exists.returncode == 0:
    run(['docker','start','pulilan-preview'],capture_output=True)
    print('Preview running.')
else:
    preview_uploads = root / 'storage' / 'preview-uploads'
    preview_uploads.mkdir(parents=True, exist_ok=True)
    file_table = run(['docker','compose','exec','-T','db','mysql','-uroot','-N','-e',f"SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='{name}' AND table_name='app_files'"],capture_output=True).stdout.strip()
    if file_table == b'1':
        stored_files = run(['docker','compose','exec','-T','db','mysql','-uroot','-N',name,'-e','SELECT stored_name FROM app_files'],capture_output=True).stdout.decode().splitlines()
        for stored in stored_files:
            if Path(stored).name != stored:
                raise RuntimeError('Invalid attachment filename')
            original = root / 'storage' / 'uploads' / stored
            target = preview_uploads / stored
            if original.is_file() and not target.exists():
                shutil.copy2(original,target)
    run(['docker','run','-d','--name','pulilan-preview','--network','pulilan_default','-p','127.0.0.1:8081:80','-e',f'DB_NAME={name}', '-e','APP_REQUIRE_RUNTIME_DB=1',
         '--mount',f'type=bind,source={root},target=/var/www/html,readonly',
         '--mount',f'type=bind,source={preview_uploads},target=/var/www/html/storage/uploads',
         '--mount',f'type=bind,source={root}/tools/apache.conf,target=/etc/apache2/sites-enabled/000-default.conf,readonly',
         '--mount','type=volume,source=pulilan_mysql_socket,target=/var/run/mysqld',
         '--entrypoint','sh','pulilan-web','/var/www/html/tools/docker-start.sh'])
print('Preview: http://127.0.0.1:8081 (isolated database)')
