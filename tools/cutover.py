"""Back up current live data, then start the verified native application."""
from datetime import datetime
from pathlib import Path
import subprocess

root = Path(__file__).resolve().parents[1]
def run(args, **kwargs):
    return subprocess.run(args,cwd=root,check=True,**kwargs)

backups = root / 'storage' / 'backups'
backups.mkdir(parents=True,exist_ok=True)
snapshot = backups / ('before-cutover-' + datetime.now().strftime('%Y%m%d-%H%M%S') + '.sql')
dump = run(['docker','compose','exec','-T','db','mysqldump','-uroot','--single-transaction','--skip-lock-tables','pulilan'],capture_output=True).stdout
snapshot.write_bytes(dump)
print('Live database backed up:',snapshot,flush=True)
fingerprints = run(['docker','compose','exec','-T','web','php','tools/data-check.php','snapshot','--stdout'], capture_output=True).stdout
(backups / 'data-preservation.json').write_bytes(fingerprints)
run(['docker','compose','up','-d','--build','--wait','--wait-timeout','180'])
run(['docker','compose','exec','-T','web','php','tools/data-check.php','verify'])
