"""Native HTTP integration checks. Always run against the isolated preview."""
import base64
import http.cookiejar
import json
import re
import subprocess
import urllib.error
import urllib.parse
import urllib.request
from html import unescape
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
BASE = 'http://127.0.0.1:8081'
checks = 0

def check(condition, description):
    global checks
    if not condition:
        raise AssertionError(description)
    checks += 1

def run_php(script, *args):
    return subprocess.run(['docker','exec','pulilan-preview','php',script,*args],cwd=ROOT,capture_output=True,check=True).stdout.decode()

class Client:
    def __init__(self):
        self.jar = http.cookiejar.CookieJar()
        self.opener = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(self.jar))

    def request(self, page='home', params=None, data=None, upload=None):
        address = BASE + '/index.php?' + urllib.parse.urlencode({'page':page, **(params or {})})
        headers = {}
        payload = None
        if data is not None:
            if upload:
                boundary = '----NativePHPTestBoundary'
                parts = []
                for key, value in data.items():
                    parts.append(f'--{boundary}\r\nContent-Disposition: form-data; name="{key}"\r\n\r\n{value}\r\n'.encode())
                name, mime, body = upload
                parts.append(f'--{boundary}\r\nContent-Disposition: form-data; name="attachment"; filename="{name}"\r\nContent-Type: {mime}\r\n\r\n'.encode() + body + b'\r\n')
                parts.append(f'--{boundary}--\r\n'.encode())
                payload = b''.join(parts)
                headers['Content-Type'] = 'multipart/form-data; boundary=' + boundary
            else:
                payload = urllib.parse.urlencode(data).encode()
        try:
            response = self.opener.open(urllib.request.Request(address,data=payload,headers=headers))
        except urllib.error.HTTPError as error:
            response = error
        body = response.read()
        text = body.decode('utf-8',errors='replace')
        check(not re.search(r'Fatal error|Parse error|Uncaught|Warning:',text),'No PHP errors: ' + page)
        return response.status, text, response.geturl(), response.headers

    def token(self, page='home', params=None):
        status, body, _, _ = self.request(page,params)
        check(status == 200,'Form page accessible: ' + page)
        return unescape(re.search(r'name="csrf" value="([^"]+)"',body).group(1))

    def login(self, user, remember=False):
        data = {'csrf':self.token('login'),'username':user['username'],'password':user['password']}
        if remember:
            data['remember_me'] = '1'
        status, body, final, _ = self.request('login',data=data)
        check(status == 200 and 'page=dashboard' in final,'Role sign-in works')

    def action(self, action, resource='', record_id='', **values):
        token = self.token('dashboard')
        return self.request('action',data={'csrf':token,'action':action,'resource':resource,'id':record_id,**values})

def record_id(address):
    return urllib.parse.parse_qs(urllib.parse.urlsplit(address).query)['id'][0]

users = json.loads(run_php('/var/www/html/tests/fixtures.php'))
clients = {role:Client() for role in users}
try:
    anon = Client()
    status, body, _, headers = anon.request()
    check(status==200 and 'Our community.' in body,'Native home page')
    check('jquery' not in body.lower() and 'bootstrap' not in body.lower(),'No frontend libraries')
    check("script-src 'self'" in headers.get('Content-Security-Policy',''),'Strict CSP')
    for resource in ['accounts','memos','resident-surveys']:
        _, _, final, _ = anon.request('records',{'resource':resource})
        check('page=login' in final,'Anonymous records protected')
    check(anon.request('contact',data={'name':'QA Visitor','email':'qa@example.test','message':'Hello'})[0]==403,'CSRF required on contact')
    contact = {'csrf':anon.token(),'name':'QA Visitor','email':'qa@example.test','message':'<script>alert(1)</script>'}
    check('Thank you.' in anon.request('contact',data=contact)[1],'Public inquiry saved')
    for role, client in clients.items():
        client.login(users[role],remember=role=='resident')
        check(client.request('reports')[0]==200,'Reports load: ' + role)
        check(client.request('profile')[0]==200,'Profile loads: ' + role)
    admin, official, resident, executive, dilg, outsider = [clients[x] for x in ['admin','official','resident','executive','dilg','outsider']]
    for role in ['official','resident','executive','dilg','outsider']:
        check(clients[role].request('records',{'resource':'accounts'})[0]==403,'Accounts protected: ' + role)
    check(resident.request('records',{'resource':'barangay-surveys'})[0]==403,'Resident cannot read barangay surveys')
    check(executive.request('edit',{'resource':'achievements'})[0]==403,'Executive cannot edit achievements')
    for resource in ['accounts','resident-records','official-records','barangays','memos','achievements','messages','resident-surveys','barangay-surveys']:
        check(admin.request('records',{'resource':resource})[0]==200,'List loads: ' + resource)
        check(admin.request('edit',{'resource':resource})[0]==200,'Editor loads: ' + resource)
    check(admin.request('history')[0]==200,'Audit history works')
    # Native account creation, hashes, approval, and no privileged public signup.
    password = 'A strong QA password!'
    signup = {'csrf':anon.token('register'),'name':'QA Signup','username':'qa_signup','email':'qa_signup@example.test','contact':'09170000000','brgy_location':'Tibag','password':password,'cpassword':password,'type':'admin'}
    status, body, _, _ = anon.request('register',data=signup)
    check(status==200 and 'administrator must enable' in body,'Registration requires approval')
    rows = admin.request('records',{'resource':'accounts','q':'qa_signup'})[1]
    check('resident' in rows and 'Disabled' in rows,'Public signup cannot escalate role')
    account_id = re.search(r'page=detail&amp;resource=accounts&amp;id=(\d+)',rows).group(1)
    values = {'name':'QA Signup','username':'qa_signup','email':'qa_signup@example.test','contact':'09170000000','type':'resident','brgy_location':'Tibag','position':'Resident','gender':'Not Specified','app_enabled':'1','password':''}
    check(admin.action('save','accounts',account_id,**values)[0]==200,'Admin enables resident account')
    signup_client = Client(); signup_client.login({'username':'qa_signup','password':password})
    # Memo lifecycle, escaping, attachments, and review permissions.
    memo = {'project_name':'QA Memo <script>alert(1)</script>','project_description':'QA memo body','memo_date':'2026-10-13','receiver':'All Barangays'}
    status, body, final, _ = admin.action('save','memos',**memo)
    check(status==200 and '&lt;script&gt;' in body and '<script>alert(1)</script>' not in body,'Memo data escaped')
    memo_id = record_id(final)
    check(resident.request('detail',{'resource':'memos','id':memo_id})[0]==404,'Pending memo hidden from residents')
    check(executive.action('review','memos',memo_id,memo_status='APPROVED')[0]==403,'Review permission enforced')
    check(dilg.action('review','memos',memo_id,memo_status='MODIFICATION REQUEST',remarks='Please update.')[0]==200,'DILG modification request')
    check(dilg.action('review','memos',memo_id,memo_status='APPROVED',remarks='Reviewed')[0]==200,'DILG approves memo')
    check(resident.request('detail',{'resource':'memos','id':memo_id})[0]==200,'Approved memo visible')
    check(resident.action('seen','memos',memo_id)[0]==200,'Per-user read status')
    check(admin.action('save','memos',memo_id,**memo)[0]==200,'Editing resets memo to pending')
    check(resident.request('detail',{'resource':'memos','id':memo_id})[0]==404,'Edited memo requires review again')
    pdf = b'%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\n%%EOF'
    token = admin.token('dashboard')
    status, body, final, _ = admin.request('action',data={'csrf':token,'action':'save','resource':'memos','id':memo_id,**memo},upload=('qa.pdf','application/pdf',pdf))
    check(status==200 and 'qa.pdf' in body,'PDF attachment uploaded')
    attachment_id = re.search(r'page=download&amp;id=(\d+)',body).group(1)
    check(admin.request('download',{'id':attachment_id})[0]==200,'Authorized download works')
    check(resident.request('download',{'id':attachment_id})[0]==404,'Pending attachment access protected')
    status, body, _, _ = admin.request('action',data={'csrf':admin.token('dashboard'),'action':'save','resource':'memos','id':memo_id,**memo},upload=('attack.php','application/octet-stream',b'<?php echo 1;'))
    check(status==200 and 'Use a PDF' in body,'Executable upload rejected')
    # Create and edit a scoped survey; field defaults mirror native form values.
    def survey_values(client, resource):
        body = client.request('edit',{'resource':resource})[1]
        from html.parser import HTMLParser
        class Parser(HTMLParser):
            def __init__(self):
                super().__init__(); self.values={}; self.select=None; self.option=None; self.selected=False; self.buffer=''
            def handle_starttag(self, tag, attrs):
                a=dict(attrs)
                if tag=='input' and a.get('name') and a.get('type') not in ['file','password']:
                    self.values[a['name']]=a.get('value','')
                if tag=='select': self.select=a.get('name')
                if tag=='option' and self.select:
                    self.option=a.get('value',''); self.selected='selected' in a
                    if self.select not in self.values or self.selected: self.values[self.select]=self.option
            def handle_endtag(self, tag):
                if tag=='select': self.select=None
        parser=Parser(); parser.feed(body)
        return {k:v for k,v in parser.values.items() if k not in ['csrf','action','resource','id']}
    survey = survey_values(resident,'resident-surveys')
    survey['no_household']='2'; survey['gender']='Female'
    status, _, final, _ = resident.action('save','resident-surveys',**survey)
    check(status==200 and 'page=detail' in final,'Resident survey submission')
    survey_id=record_id(final)
    outside_survey = survey_values(outsider,'resident-surveys')
    status, _, outside_final, _ = outsider.action('save','resident-surveys',**outside_survey)
    check(status==200 and 'page=detail' in outside_final,'Another barangay survey exists for scope verification')
    outside_id = record_id(outside_final)
    check(official.request('detail',{'resource':'resident-surveys','id':outside_id})[0]==404,'Official cannot read another barangay survey')
    check(outsider.request('detail',{'resource':'resident-surveys','id':survey_id})[0]==404,'Other resident cannot read survey')
    check(official.request('detail',{'resource':'resident-surveys','id':survey_id})[0]==200,'Official can read own barangay survey')
    survey['no_household']='-10'
    check('non-negative whole number' in resident.action('save','resident-surveys',survey_id,**survey)[1],'Negative survey counts rejected')
    brgy = survey_values(official,'barangay-surveys')
    brgy['no_household']='15'; brgy['no_families']='17'
    status, _, final, _ = official.action('save','barangay-surveys',**brgy)
    check(status==200 and 'page=detail' in final,'Official barangay survey submission')
    csv = official.request('export',{'resource':'resident-surveys'})
    check(csv[0]==200 and 'QA Resident' in csv[1] and 'QA Outsider' not in csv[1],'Scoped CSV export')
    check('password' not in admin.request('export',{'resource':'accounts'})[1].splitlines()[0].lower(),'Password hashes excluded from export')
    # Archives are reversible and cannot be used for cross-scope writes.
    check(outsider.action('archive','resident-surveys',survey_id)[0]==403,'Resident cannot archive')
    check(official.action('archive','resident-surveys',survey_id)[0]==200,'Official can archive scoped survey')
    check(resident.request('detail',{'resource':'resident-surveys','id':survey_id})[0]==404,'Archived survey hidden')
    check(official.action('restore','resident-surveys',survey_id)[0]==200,'Survey restore works')
    check(resident.request('detail',{'resource':'resident-surveys','id':survey_id})[0]==200,'Restored survey visible')
    check(admin.action('archive','accounts',str(users['admin']['id']))[0]==422,'Self-archive prevented')
    # Remaining consolidated editors and local inbox replies.
    for resource, values in [
        ('barangays',{'psgc':'999999999','brgy_name':'QA Barangay','classification':'Rural','brgy_alt_name':'QA','density':'10 /km²','land_area_per_square_meter':'1000 m²','c_pop':'1%'}),
        ('achievements',{'project_name':'QA Achievement','project_description':'QA community project'}),
        ('resident-records',{'name':'QA Profile','email':'qa_profile@example.test','contact':'09170000000','gender':'Not Specified','brgy_location':'Tibag','province':'Bulacan','address':'QA Street','city_municipality':'Pulilan','purok_district':'1','civil_status':'Single','position':'Resident'}),
        ('official-records',{'fullname':'QA Official Profile','email':'qa_official@example.test','contact':'09170000000','brgy_location':'Tibag','gender':'Male','position':'Chairman','no_purok':'7','major_sources':'Agriculture','brgy_classification':'Urban','char_brgy':'Plain', **{f'{gender}_{job}':'0' for gender in ['male','female'] for job in ['tanod','health_worker','nutrition_scholar','purok_leaders','librarian','day_care_worker','utility_worker']}}),
    ]:
        status, body, final, _ = admin.action('save',resource,**values)
        check(status==200 and 'page=detail' in final,'Create ' + resource)
        created_id = record_id(final)
        check(admin.action('save',resource,created_id,**values)[0]==200,'Edit ' + resource)
        if resource=='resident-records':
            check(official.request('detail',{'resource':resource,'id':created_id})[0]==200,'Official sees local resident profile')
        check(admin.action('archive',resource,created_id)[0]==200,'Archive ' + resource)
        check(admin.action('restore',resource,created_id)[0]==200,'Restore ' + resource)
    status, body, final, _ = resident.action('save','messages',subject='QA Request',message='Please help with my profile.')
    check(status==200 and 'page=detail' in final,'Resident sends message')
    message_id = record_id(final)
    check(outsider.request('detail',{'resource':'messages','id':message_id})[0]==404,'Other resident cannot read message')
    status, body, final, _ = admin.action('reply','messages',message_id,message='QA reply to your inquiry.')
    check(status==200 and 'QA reply' in body,'Administrator reply saved')
    check('QA reply' in resident.request('detail',{'resource':'messages','id':record_id(final)})[1],'Resident receives reply')
    # Revocation works for already signed-in users, including after restore.
    check(admin.action('archive','accounts',str(users['outsider']['id']))[0]==200,'Archive another account')
    check('page=login' in outsider.request('dashboard')[2],'Archived account immediately loses access')
    check(admin.action('restore','accounts',str(users['outsider']['id']))[0]==200,'Restore account')
    check('page=login' in outsider.request('dashboard')[2],'Restoring does not restore old sessions')
    other_session = Client(); other_session.login(users['resident'])
    new_password = 'A changed QA password!'
    result = resident.action('profile',name='QA Resident',email='qa_resident@example.test',contact='09170000000',current_password=users['resident']['password'],new_password=new_password,cpassword=new_password)
    check(result[0]==200 and 'Profile updated.' in result[1],'Password change works')
    check('page=login' in other_session.request('dashboard')[2],'Password change revokes other sessions')
    # Reissue remember-me with the new password to check rotation below.
    resident.action('logout')
    resident.login({'username':users['resident']['username'],'password':new_password},remember=True)
    # Persistent sign-in and logout invalidation.
    remember = next(c for c in resident.jar if c.name=='remember_me')
    only_remember = Client(); only_remember.jar.set_cookie(remember)
    check('page=dashboard' in only_remember.request('dashboard')[2],'Remember-me restores session')
    check('page=login' in only_remember.action('logout')[2],'Logout clears access')
    check('page=login' in only_remember.request('dashboard')[2],'Logged-out session remains anonymous')
    # Private source and backups are outside the document root.
    for path in ['/app/database.php','/database/schema.sql','/legacy/login.php','/storage/backups/','/docs/']:
        try: response = urllib.request.urlopen(BASE+path); status=response.status
        except urllib.error.HTTPError as error: status=error.code
        check(status in [403,404],'Private path blocked: ' + path)
    print(f'PASS: {checks} HTTP and permission assertions.')
finally:
    print(run_php('/var/www/html/tests/fixtures.php','cleanup').strip())
