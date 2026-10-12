"""Build the project citizen guide PDF; ReportLab is a maintenance dependency only."""
from pathlib import Path
from xml.sax.saxutils import escape
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, PageBreak, Image
from reportlab.lib import colors
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.enums import TA_CENTER
from reportlab.lib.pagesizes import A4

root = Path(__file__).resolve().parents[1]
target = root / 'public/documents/project/citizen-charter.pdf'
target.parent.mkdir(parents=True, exist_ok=True)
styles = getSampleStyleSheet()
styles.add(ParagraphStyle(name='TitleLocal', fontName='Helvetica-Bold', fontSize=26, leading=30, textColor=colors.HexColor('#125c71'), spaceAfter=16))
styles.add(ParagraphStyle(name='HeadingLocal', fontName='Helvetica-Bold', fontSize=17, leading=21, textColor=colors.HexColor('#125c71'), spaceAfter=12))
styles.add(ParagraphStyle(name='BodyLocal', fontSize=10, leading=15, spaceAfter=8))
styles.add(ParagraphStyle(name='CellLocal', fontSize=8, leading=11))
styles.add(ParagraphStyle(name='LabelLocal', fontName='Helvetica-Bold', fontSize=9, leading=13, spaceAfter=6))
styles.add(ParagraphStyle(name='CoverSmall', fontSize=11, leading=16, alignment=TA_CENTER, spaceAfter=12))
story = []
def p(text, style='BodyLocal'):
    return Paragraph(text, styles[style])
def add(text, style='BodyLocal'):
    story.append(p(text, style))
def heading(number, title):
    add(f'{number:02d} / CITIZEN GUIDE', 'LabelLocal')
    add(title, 'HeadingLocal')
def bullets(items):
    for item in items: add('- ' + item)
def box(text):
    table=Table([[p(text)]], colWidths=[507])
    table.setStyle(TableStyle([('BACKGROUND',(0,0),(-1,-1),colors.HexColor('#eaf3f5')),('BOX',(0,0),(-1,-1),.6,colors.HexColor('#b7d1da')),('LEFTPADDING',(0,0),(-1,-1),12),('RIGHTPADDING',(0,0),(-1,-1),12),('TOPPADDING',(0,0),(-1,-1),10),('BOTTOMPADDING',(0,0),(-1,-1),6)]))
    story.extend([table,Spacer(1,12)])
def metadata(who, requirements, output):
    add('<b>Responsible unit:</b> Project administrator and authorized role holders. MICTO is the municipal technology-office reference; project assignment requires municipal approval.')
    add('<b>Service type:</b> Project self-service / assisted service. Government transaction classification has not been approved.')
    add('<b>Who may avail:</b> '+who)
    add('<b>Requirements and where to secure:</b> '+requirements)
    add('<b>Service output:</b> '+output)
    add('<b>Fees:</b> The portal does not collect fees for this service. Connectivity, printing, and unrelated municipal transactions may have separate costs.')
def steps(rows):
    headers=['Step','Citizen / client steps','System / staff actions','Fees','Processing time','Responsible person']
    data=[[p(escape(x),'CellLocal') for x in headers]]
    data += [[p(escape(str(x)),'CellLocal') for x in row] for row in rows]
    t=Table(data,colWidths=[35,117,125,42,85,103],repeatRows=1,hAlign='LEFT')
    t.setStyle(TableStyle([('BACKGROUND',(0,0),(-1,0),colors.HexColor('#dcebf0')),('VALIGN',(0,0),(-1,-1),'TOP'),('GRID',(0,0),(-1,-1),.45,colors.HexColor('#b9cbd3')),('ROWBACKGROUNDS',(0,1),(-1,-1),[colors.white,colors.HexColor('#f5f8fa')]),('LEFTPADDING',(0,0),(-1,-1),6),('RIGHTPADDING',(0,0),(-1,-1),6),('TOPPADDING',(0,0),(-1,-1),8),('BOTTOMPADDING',(0,0),(-1,-1),8)]))
    story.extend([t,Spacer(1,12)])
def page(): story.append(PageBreak())

story.append(Image(str(root/'public/assets/images/official/pulilan-logo.png'),width=76,height=76))
story.append(Spacer(1,18))
add('PULILAN, BULACAN', 'CoverSmall')
add('Community-Based<br/>Monitoring System', 'TitleLocal')
add("Citizen's Charter<br/>Project service guide", 'HeadingLocal')
box('<b>PROJECT DRAFT - FOR CITIZEN GUIDANCE</b><br/>Version 1.0 | October 13, 2026<br/>Prepared for this college thesis portal. This document is not an issued or approved municipal Citizen\'s Charter. The municipal seal identifies Pulilan and does not imply government endorsement.')
add('<b>Municipal technology-office reference</b><br/>Municipal Information and Communications Technology Office (MICTO)<br/>Directory telephone: (044) 764-9398<br/>Directory email: icto.pulilan@gmail.com')
add('The portal brings barangay profiles, resident surveys, approved updates, and local messages together. Access depends on your account role and barangay assignment. It does not issue permits or replace municipal offices.')
add('<b>Guide contents</b>','LabelLocal')
bullets(['2. Register, activate, and sign in','3. Complete or correct your resident survey','4. Read municipal information and permitted reports','5. Send inquiries and request assistance','6. Staff workflows, privacy, and accessibility','7. Feedback, service boundaries, and sources'])
add('Availability depends on the project deployment. The current Docker setup is local-only; a public URL and office service hours have not been approved.')
page()

heading(2,'Register, activate, and sign in')
metadata('Residents creating a resident account; existing authorized users signing in.', 'Name, valid email, contact details if available, barangay, unique username, and password supplied by the applicant. No ID-document upload is requested by the registration form.', 'Resident registration awaiting approval, followed by an authenticated workspace once enabled.')
steps([
 ('1','Choose Register. Enter accurate details and your barangay.','Validate the form and reject duplicate usernames.','None','About 3-5 minutes to complete the form (estimate).','Applicant; system validation'),
 ('2','Use a matching password and confirmation; submit once.','Store a hashed password and a disabled resident account.','None','After successful form validation; depends on connection.','Applicant; portal'),
 ('3','Ask the project administrator about activation if needed.','Review the account and enable it when appropriate.','None','Manual approval; no approved turnaround published.','Project administrator'),
 ('4','Choose Sign in and enter your username and password.','Verify credentials and account status; open your workspace.','None','About 1 minute of user effort (estimate).','Account holder; portal'),
])
box('<b>Password rules:</b> 12-72 bytes. A typical ASCII password uses one byte per character. Username: 3-100 letters, numbers, dots, underscores, or hyphens. Registration never grants an administrator or official role.')
add('<b>If sign-in fails:</b> Check the username and password. A disabled or archived account cannot sign in. There is no automated email password-reset feature; request administrator assistance through a trusted channel. Never send your password in a message.')
add('<b>Security:</b> Avoid Remember me on shared devices. Sign out after use. Changing your password revokes previous sessions. Repeated attempts may be temporarily limited; wait and try again.')
page()

heading(3,'Complete or correct your resident survey')
metadata('Enabled resident accounts for their own surveys; assigned barangay officials assisting within their permitted barangay.', 'Enabled account from the project administrator; accurate household and community information from the respondent. No uploaded identity document is required for the survey workflow.', 'A saved resident survey linked to your account and available within permitted scopes.')
steps([
 ('1','Sign in. Open Resident surveys, then the available create or edit action.','Show only records within the account\'s permitted scope.','None','About 1-2 minutes of user effort.','Resident; assigned official if assisting'),
 ('2','Complete household details and required fields.','Provide the shared survey form and field validation.','None','About 10-20 minutes depending on the information (estimate).','Respondent'),
 ('3','Review your answers and choose Save.','Validate and store the record; log the action.','None','After validation; connection and server dependent.','Respondent; portal'),
 ('4','Reopen your survey to review or correct an answer.','Check ownership or barangay scope before allowing edits.','None','About 2-5 minutes for a simple correction.','Resident or authorized barangay official'),
])
add('<b>Before you submit:</b> Use truthful counts and dates. Do not guess information for another household. Leave optional fields blank when they do not apply. Required-field and validation messages explain what needs correction.')
add('<b>When an error appears:</b> Read the message, correct the affected fields, and submit again. Do not repeatedly click Save. If the form expires, reload it and retry. Contact the administrator if a saved record cannot be found.')
box('<b>Data corrections and archives:</b> Residents can edit their own permitted surveys. Archiving and restoring records require an authorized role. Request assistance if an archived or misassigned record needs recovery; there is no citizen permanent-delete action.')
add('User-effort estimates in this guide are orientation only, not approved government processing times or guaranteed service levels.')
page()

heading(4,'Read updates, guides, and permitted reports')
metadata('Visitors for public barangay profiles and PDFs; signed-in users for approved addressed memos, achievements, and permitted reports.', 'No account for public information. Enabled account for workspace information; the responsible administrator assigns roles and barangays.', 'Viewed information, downloaded public reference PDFs, or permitted report exports.')
steps([
 ('1','Open the home page and browse or search barangays.','Show the profiles recorded in this project.','None','About 1-3 minutes of user effort.','Visitor; portal'),
 ('2','Choose a municipal PDF guide or blank form.','Provide a local reference copy and official source link.','None','Download time depends on file size and connection.','Visitor; portal'),
 ('3','Sign in to read available memos and achievements.','Show approved addressed memos and role-permitted information.','None','About 1-3 minutes of user effort.','Account holder; portal'),
 ('4','Open Reports; use available export or print controls.','Enforce the user\'s record scope; exclude password fields from CSV.','None','After a valid request; dataset and server dependent.','Authorized account holder'),
])
add('<b>Public references:</b> Citizen charters for planning, social welfare, and population services are copied from the official municipal website. Blank building and occupancy application forms are provided for reference. The portal does not accept, approve, or issue these permits.')
add('<b>Report boundaries:</b> Residents see their own permitted data; officials see assigned-barangay data. Administrators, executives, and DILG users have the configured municipal scope. A downloaded CSV or printed page is not a certified government document.')
box('<b>Dates matter:</b> This project\'s barangay profiles are stored records, not a live census feed. The official demographic webpage contains figures from different years. Check the original source and responsible office before relying on statistics or application requirements.')
page()

heading(5,'Send inquiries and request assistance')
metadata('Visitors using the home-page contact form; enabled users using the local inbox and message features available to their role.', 'Name, valid email, and a clear concern from the sender. For account support, provide your username and barangay, never your password or an unnecessary identity document.', 'A saved project inquiry; eligible signed-in users may receive an administrator reply in their local inbox.')
steps([
 ('1','Open Contact on the home page, or the available signed-in message form.','Present the inquiry form.','None','About 2-5 minutes of user effort.','Sender'),
 ('2','Describe the issue and submit. Avoid unnecessary sensitive details.','Validate the message, apply abuse limits, and save it locally.','None','After successful validation; connection dependent.','Sender; portal'),
 ('3','For signed-in inquiries, check your local inbox later.','Administrator reviews and may reply to an eligible account.','None','Manual response; no approved turnaround published.','Project administrator'),
 ('4','For a public inquiry requiring follow-up, use the agreed contact channel.','A public inquiry has no signed-in inbox recipient.','None','Outside-portal follow-up; timing not set.','Sender; project administrator'),
])
box('<b>Messages stay in this project.</b> Submitting a form does not send email to MICTO or any government office. Automated email delivery is not configured. Use the official directory contact when you intend to reach the municipality itself.')
add('<b>For technical guidance:</b> The official directory lists MICTO at (044) 764-9398 and icto.pulilan@gmail.com. These are published municipal contacts, not a confirmed support contract for this thesis portal. Verify availability directly.')
add('<b>For urgent situations:</b> Do not rely on this project inbox for emergency assistance. Use the current official municipal emergency contacts or the appropriate emergency service.')
page()

heading(6,'Staff workflows, privacy, and accessibility')
add('<b>How the service operates behind the scenes</b>','LabelLocal')
bullets([
 'Administrator: manages accounts, records, archives, local messages, and audit history; public resident accounts require activation.',
 'Barangay official: maintains resident profiles and surveys within the assigned barangay and submits barangay surveys.',
 'Executive: reads municipal surveys and reports and creates or edits memos.',
 'DILG: reads surveys and reports, reviews memos, and maintains achievements.',
 'Resident: maintains own surveys, uses own inbox, and reads permitted approved updates.',
])
add('<b>Memo workflow:</b> An authorized creator saves a memo; an administrator or DILG reviewer records approval, decline, or a modification request. Only approved addressed memos are visible to their eligible citizen or barangay recipients. Staff review has no approved processing-time commitment in this project.')
add('<b>Privacy and safe use</b>','LabelLocal')
bullets([
 'The project stores account/contact details and submitted community information. Access is restricted by role, ownership, and barangay assignment.',
 'Use only information relevant to the form. Do not include passwords, bank details, or unnecessary identity documents in inquiries.',
 'Ask the administrator to correct access or record problems. The project has no published municipal retention schedule or automated citizen erasure service.',
 'Attachment access is permission-checked. Authorized attachment workflows accept PDF, JPEG, PNG, or WebP files up to 5 MB; unsupported files are rejected.',
 'The current service is local-only. A public deployment needs approved privacy notices, responsible office assignment, HTTPS, and support arrangements.',
])
add('<b>Accessibility options</b>','LabelLocal')
add('Use the bottom-right Accessibility options panel for larger text, dark or high-contrast mode, grayscale content, plain Arial font, increased spacing, emphasized links, hidden decorative images, and reduced motion. Preferences are stored in this browser when available. Reset restores defaults; device reduced-motion settings take priority.')
add('Use Tab to move between controls, Enter or Space to activate them, and Escape to close the accessibility panel. Skip to content and Back to top move to page landmarks. Ask for assistance if a source PDF is difficult to read; PDF accessibility is not certified.')
page()

heading(7,'Feedback, service boundaries, and sources')
add('<b>Give feedback or report a service issue</b>','LabelLocal')
add('Use the project contact form or an available signed-in message form. Include the feature name, what happened, the approximate date/time, and your expected result. Avoid sending sensitive screenshots or another person\'s records. A project administrator must review the issue; no approved complaint-resolution timeline is set.')
add('For government service concerns, contact the responsible municipal office through the official directory. The project administrator is not a substitute for the municipality\'s complaints, appeals, or data-protection procedures.')
box('<b>Document status and approval</b><br/>Draft version 1.0, prepared October 13, 2026. This guide describes the implemented portal. Responsible-office assignment, government service classification, staffing, official fees, schedules, response commitments, retention rules, and final approval remain for the municipality to determine. No signature or approval is implied.')
add('<b>Verified reference contacts</b>','LabelLocal')
add('MICTO: (044) 764-9398 | icto.pulilan@gmail.com<br/>Office of the Municipal Mayor: (044) 764-0100 | pulilan.gov@gmail.com<br/>Contacts are directory references reviewed October 13, 2026; confirm them before use.')
add('<b>Official sources</b>','LabelLocal')
for label,url in [
 ('Municipal office directory','https://pulilan.gov.ph/government/office-directories/'),
 ('Citizen\'s Charter directory','https://pulilan.gov.ph/citizens-charter/'),
 ('Municipal forms','https://pulilan.gov.ph/downloadable-forms/'),
 ('Municipal demographic reference','https://pulilan.gov.ph/about-pulilan/demographic-profile/'),
]:
    add(f'{escape(label)}<br/><link href="{url}" color="#125c71">{url}</link>')
add('<b>Project basis:</b> Native portal workflows, role definitions, registration checks, shared forms, reporting, local messages, and security controls in this repository. This document introduces no additional service entitlement or government-approved performance standard.')
add('To maintain this guide, edit tools/build-citizen-charter.py, regenerate the PDF, and review every rendered page before release. The browser viewer also provides a direct PDF link if embedded viewing is unavailable.')

def footer(canvas, doc):
    canvas.saveState()
    w,h=A4
    canvas.setStrokeColor(colors.HexColor('#b9cbd3'));canvas.line(44,43,w-44,43)
    canvas.setFont('Helvetica',8);canvas.setFillColor(colors.HexColor('#586b77'))
    canvas.drawString(44,30,'Pulilan CBMS | PROJECT DRAFT | Version 1.0 - 13 October 2026')
    canvas.drawRightString(w-44,30,f'Page {doc.page}')
    canvas.restoreState()
doc=SimpleDocTemplate(str(target),pagesize=A4,rightMargin=44,leftMargin=44,topMargin=40,bottomMargin=58,title='Pulilan CBMS Citizen Charter - Project Draft',author='Pulilan CBMS project',subject='Citizen guidance for registration, surveys, information, and support',lang='en')
doc.build(story,onFirstPage=footer,onLaterPages=footer)
print(target)
