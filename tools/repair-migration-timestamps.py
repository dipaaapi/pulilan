"""Restore automatic profile timestamps touched by the initial password migration.

Uses the private pre-cutover dump as a reference, never restores passwords.
"""
from pathlib import Path
import subprocess

root = Path(__file__).resolve().parents[1]
reference = 'pulilan_preservation_reference'
def mysql(*args, **kwargs):
    return subprocess.run(['docker','compose','exec','-T','db','mysql','-uroot',*args],cwd=root,check=True,**kwargs)

exists = mysql('-N','-e',f"SELECT COUNT(*) FROM information_schema.schemata WHERE schema_name='{reference}'",capture_output=True).stdout.strip()
if exists != b'0':
    raise RuntimeError('Reference database already exists; refusing to overwrite it.')
dump = sorted((root/'storage'/'backups').glob('before-cutover-*.sql'))[-1]
mysql('-e',f'CREATE DATABASE `{reference}`')
try:
    mysql(reference,input=dump.read_bytes())
    for table, key in [('brgydetails_tbl','brgydetails_id'),('residentdetails_tbl','user_id')]:
        mysql('-e',f'UPDATE pulilan.`{table}` current JOIN `{reference}`.`{table}` original ON current.`{key}`=original.`{key}` SET current.date_added=original.date_added')
    print('Original profile timestamps restored; password hashes retained.')
finally:
    # Only this newly created reference copy is removed. The SQL backup remains.
    mysql('-e',f'DROP DATABASE `{reference}`')
