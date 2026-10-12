# Official Pulilan assets

## Community photo carousel

The homepage image frame uses three locally copied photos: the municipal hall,
San Isidro Labrador Parish Church during festivities, and Carabao Festival
street dancers. `app/content/community-images.json` records original URLs,
source pages, retrieval dates, alternative text, and SHA-256 hashes. Photos were
selected from the official demographic page and homepage and visually inspected.
Embedded credits are preserved; review original rights before broader reuse.

`views/components/hero-carousel.php` and `public/assets/js/carousel.js` rotate
only the images every six seconds, looping to the first. The caption stays fixed.
Images slide from right to left using native browser animations, without visible
navigation controls or a counter. Autoplay pauses on hover, hidden pages,
offscreen content, open modals, hidden decorative images, and reduced-motion
settings. Without JavaScript, the first image remains visible. No carousel library is used.

## Documents and branding

Retrieved October 13, 2026 from the Municipality of Pulilan website.
`app/content/official-assets.json` records original URLs, source pages, file sizes,
SHA-256 hashes, and retrieval dates. `tools/fetch-official-assets.py` maintains the
curated list with bounded downloads and PDF/PNG signature checks. It is a
maintenance tool, not a runtime crawler.

## Included resources

| Resource | Local location | Project use |
| --- | --- | --- |
| Planning and Development Citizen Charter 2026 | `public/documents/official/planning-charter-2026.pdf` | Development and location clearance guidance; 21 pages |
| Social Welfare Citizen Charter 2026 | `public/documents/official/social-welfare-charter-2026.pdf` | Crisis assistance and welfare services; 25 pages |
| Population Office Citizen Charter 2026 | `public/documents/official/population-charter-2026.pdf` | Population records and demographic data requests; 7 pages |
| Building permit application | `public/documents/official/building-permit.pdf` | Blank resident form; 2 pages |
| Occupancy application | `public/documents/official/occupancy-application.pdf` | Blank resident form; 1 page |
| Municipal logo | `public/assets/images/official/pulilan-logo.png` | Shared header seal; original 252 × 252 PNG |
| Municipal website icon | `public/assets/images/official/pulilan-icon.png` | Browser favicon; original 244 × 244 PNG |

The files are unmodified local copies. The homepage presents the PDFs in a
shared download component with source links, sizes, dates, and concise service
summaries. The project does not process permit applications or send forms to
municipal offices. No WordPress code, CSS frameworks, icon fonts, or third-party
scripts were imported. Inspection tools installed in the local Python environment
are not application dependencies.

## Sources and attribution

- [Citizen's Charter directory](https://pulilan.gov.ph/citizens-charter/)
- [Downloadable forms](https://pulilan.gov.ph/downloadable-forms/)
- [Municipal homepage and branding](https://pulilan.gov.ph/)

The official footer states that content is public domain unless otherwise
stated. Preserve municipal attribution and check any document-specific notices
before wider redistribution. Displaying the municipal seal identifies the
project's subject; it does not establish municipal endorsement or certification.
Do not reuse it to imply approval of records, permits, or private services.

The download paths contain older upload-year folders, but the three charter
cover pages explicitly identify 2026 (1st Edition). Their vision text differs
from the standalone vision page. These are dated source documents; the homepage
vision summary remains attributed to its own published webpage. Older forms
are labelled as reference copies rather than guaranteed current requirements.

PDFs were opened with a parser, page counts and first-page text checked, and
first-page previews rendered. Municipal logo and icon were visually inspected.
Complex tables and scanned content may require assistance; PDF accessibility
has not been certified. Recheck the official site before relying on requirements.
