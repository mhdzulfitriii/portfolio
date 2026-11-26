# Portfolio Media Assets (`asset/`)

Drop your personal photos and resume PDF into the folders below to replace the starter showcase graphics with your real photography and screenshots.

## Quick Replacement Guide

| File / Folder | Used On | How to Update |
| :--- | :--- | :--- |
| `asset/profile.jpg` (or `.webp` / `.png`) | Home (`index.php`) Hero Card | Simply add the file — detected automatically. |
| `asset/resume.pdf` | Header CTA across all pages | Simply add the file — switches **Print CV** to **Resume (PDF)** automatically. |
| `asset/projects/` | `projects.php` & Home preview | Place `.webp` / `.jpg` screenshots here and update `"image"` or `"gallery"` in `data/project.json`. |
| `asset/experience/` | `experience.php` & Home preview | Place workplace / event photos here and update `"image"` or `"gallery"` in `data/experience.json`. |
| `asset/education/` | `education.php` & Home preview | Place campus / convocation / award photos here and update `"image"` or `"gallery"` in `data/education.json`. |
| `asset/photography/` | `photography.php` & Home preview | Place event photos here and update `"src"` or `"gallery"` in `data/photography.json`. |
| `asset/volunteer/` | `volunteer.php` & Home preview | Place volunteer programme photos here and update `"image"` or `"gallery"` in `data/volunteer.json`. |
| `asset/organizations/` | `volunteer.php` (Organizations section) | Place NGO / Persatuan photos (e.g., PKPIM) here and update `"image"` or `"gallery"` in `data/organization.json`. |

## Adding Multi-Image Galleries

Every item in `project.json`, `experience.json`, `education.json`, and `photography.json` supports an optional `"gallery"` array that automatically unlocks multi-image Previous/Next navigation inside the Lightbox:

```json
"gallery": [
  {
    "src": "asset/photography/msealp-01.webp",
    "alt": "Delegates gathered during the opening keynote at MSEALP",
    "caption": "Opening session featuring regional ASEAN delegates."
  },
  {
    "src": "asset/photography/msealp-02.webp",
    "alt": "Official dinner event attended by national leadership",
    "caption": "Formal evening coverage."
  }
]
```
