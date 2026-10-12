"""Download a curated, bounded set of public municipal resources (maintenance only)."""
from pathlib import Path
from urllib.request import Request, urlopen
from urllib.parse import urlparse
from hashlib import sha256
import json

root = Path(__file__).resolve().parents[1]
base = 'https://pulilan.gov.ph'
charter = base + '/citizens-charter/'
forms = base + '/downloadable-forms/'
items = [
    ('Planning and Development Citizen Charter', '/wp-content/uploads/2023/01/CC-2026-MPDO.pdf', 'documents/official/planning-charter-2026.pdf', charter, 'charter'),
    ('Social Welfare Citizen Charter', '/wp-content/uploads/2023/01/CC-2026-MSWDO.pdf', 'documents/official/social-welfare-charter-2026.pdf', charter, 'charter'),
    ('Population Office Citizen Charter', '/wp-content/uploads/2023/01/CC-2026-POPULATION.pdf', 'documents/official/population-charter-2026.pdf', charter, 'charter'),
    ('Unified Building Permit Application', '/wp-content/uploads/2023/09/UNIFIED-FORM-FOR-BLDG-PERMIT.pdf', 'documents/official/building-permit.pdf', forms, 'form'),
    ('Certificate of Occupancy Application', '/wp-content/uploads/2023/09/Unified-Application-Form-for-Certificate-of-Occupancy.pdf', 'documents/official/occupancy-application.pdf', forms, 'form'),
    ('Pulilan municipal logo', '/wp-content/themes/brp21/assets/images/logo-pulilan.png', 'assets/images/official/pulilan-logo.png', base + '/', 'logo'),
    ('Pulilan site icon', '/wp-content/themes/brp21/assets/images/favicon.png', 'assets/images/official/pulilan-icon.png', base + '/', 'icon'),
]
manifest = []
for title, remote, local, page, kind in items:
    url = base + remote
    request = Request(url, headers={'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Accept': '*/*'})
    with urlopen(request, timeout=45) as response:
        if urlparse(response.url).hostname not in ['pulilan.gov.ph', 'www.pulilan.gov.ph']:
            raise RuntimeError('Unexpected download host')
        data = response.read(20 * 1024 * 1024 + 1)
        content_type = response.headers.get_content_type()
    if len(data) > 20 * 1024 * 1024: raise RuntimeError('Resource exceeds 20 MB')
    signature = b'%PDF-' if local.endswith('.pdf') else b'\x89PNG\r\n\x1a\n'
    if not data.startswith(signature): raise RuntimeError('Unexpected resource format: ' + title)
    target = root / 'public' / local
    target.parent.mkdir(parents=True, exist_ok=True)
    target.write_bytes(data)
    manifest.append({'title': title, 'source_url': url, 'source_page': page, 'local_path': local, 'kind': kind, 'retrieved': '2026-10-13', 'bytes': len(data), 'sha256': sha256(data).hexdigest(), 'content_type': content_type})
    print(title, len(data), 'bytes', flush=True)
(root / 'app/content/official-assets.json').write_text(json.dumps(manifest, indent=2) + '\n', encoding='utf-8')
print('Source manifest saved.')
