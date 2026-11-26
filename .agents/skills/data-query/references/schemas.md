# Portfolio JSON Schemas

All files in `data/` must be UTF-8 encoded, formatted with 2-space indentation, and use a top-level JSON array (`[]`).

## Shared Field Conventions

- `id` *(string, required)*: Unique kebab-case identifier within the file (e.g., `"smart-campus-ux"`).
- Dates: Use `"YYYY-MM"` for ranges (projects/experience/education) and `"YYYY-MM-DD"` for photography captures. Use `null` for `end_date` when `is_current` is `true`.
- Local assets: Store files in `asset/` (e.g., `asset/projects/campus-ux.webp`, `asset/photography/melaka-sunset.webp`) and reference them as relative paths without a leading slash.
- `alt` *(string, required whenever an image path is present)*: Concise, descriptive alternative text for screen readers.

---

## 1. `data/project.json`

Represents software, UI/UX, or HCI projects and case studies.

| Field | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `id` | `string` | Yes | Unique kebab-case slug |
| `title` | `string` | Yes | Project name |
| `tagline` | `string` | Yes | One-line value proposition (≤ 120 chars) |
| `description` | `string` | Yes | Short summary of problem, process, and outcome |
| `category` | `string` | Yes | e.g., `"HCI / UX"`, `"Web App"`, `"Mobile App"`, `"Research"` |
| `role` | `string` | Yes | Your role (e.g., `"UI/UX Designer & Frontend Dev"`) |
| `year` | `string` | Yes | `"YYYY"` or `"YYYY-MM"` |
| `tags` | `string[]` | Yes | Technologies or HCI methods (e.g., `["Figma", "Usability Testing", "PHP"]`) |
| `image` | `string` | No | Relative path under `asset/` |
| `image_alt` | `string` | If `image` set | Accessible description of the project visual |
| `highlights` | `string[]` | No | 2–4 measurable outcomes or HCI findings |
| `live_url` | `string \| null` | No | Live demo or prototype URL |
| `repo_url` | `string \| null` | No | Source repository URL |
| `case_study_url` | `string \| null` | No | Link to detailed HCI report / Figma / PDF |
| `featured` | `boolean` | Yes | `true` to highlight on the main portfolio view |
| `order` | `number` | No | Optional manual display priority (lower = earlier) |

### Example

```json
[
  {
    "id": "utem-portal-redesign",
    "title": "Student Portal HCI Redesign",
    "tagline": "Streamlining course registration with heuristic evaluation and rapid prototyping.",
    "description": "Evaluated an existing academic portal using Nielsen's 10 heuristics, ran usability testing with 12 students, and redesigned the navigation and timetable flow.",
    "category": "HCI / UX",
    "role": "Lead UX Researcher & Prototyper",
    "year": "2026",
    "tags": ["Heuristic Evaluation", "Figma", "Usability Testing", "Tailwind CSS"],
    "image": "asset/projects/portal-redesign.webp",
    "image_alt": "Redesigned student timetable interface showing weekly course blocks and quick filter controls",
    "highlights": [
      "Reduced task completion time by 42% in think-aloud testing",
      "Achieved WCAG 2.1 AA contrast compliance across all views"
    ],
    "live_url": null,
    "repo_url": "https://github.com/example/portal-redesign",
    "case_study_url": null,
    "featured": true,
    "order": 1
  }
]
```

---

## 2. `data/experience.json`

Represents internships, part-time/full-time work, freelance roles, and university leadership.

| Field | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `id` | `string` | Yes | Unique kebab-case slug |
| `role` | `string` | Yes | Job title or position |
| `organization` | `string` | Yes | Company, lab, or club name |
| `type` | `string` | Yes | `"Internship"`, `"Full-time"`, `"Part-time"`, `"Freelance"`, or `"Leadership"` |
| `location` | `string` | Yes | City/State or `"Remote"` |
| `start_date` | `string` | Yes | `"YYYY-MM"` |
| `end_date` | `string \| null` | Yes | `"YYYY-MM"` or `null` if ongoing |
| `is_current` | `boolean` | Yes | `true` if currently active |
| `summary` | `string` | Yes | Brief 1–2 sentence overview |
| `highlights` | `string[]` | Yes | 2–4 action-oriented bullet achievements |
| `skills` | `string[]` | No | Tools or methodologies applied |

### Example

```json
[
  {
    "id": "uiux-intern-2026",
    "role": "UI/UX Design Intern",
    "organization": "Example Digital Studio",
    "type": "Internship",
    "location": "Melaka, Malaysia",
    "start_date": "2026-03",
    "end_date": null,
    "is_current": true,
    "summary": "Collaborated with product engineers to design accessible web components and conduct user interviews.",
    "highlights": [
      "Built a reusable Tailwind component inventory covering 18 core UI patterns",
      "Facilitated 8 remote usability sessions and synthesized findings into sprint tickets"
    ],
    "skills": ["Figma", "Tailwind CSS", "User Interviews", "Accessibility"]
  }
]
```

---

## 3. `data/education.json`

Represents formal academic qualifications and relevant coursework.

| Field | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `id` | `string` | Yes | Unique kebab-case slug |
| `institution` | `string` | Yes | University or college name |
| `degree` | `string` | Yes | Programme name (e.g., `"Bachelor of Computer Science (Interactive Media)"`) |
| `faculty` | `string` | No | Faculty or department name |
| `location` | `string` | No | City, Country |
| `start_date` | `string` | Yes | `"YYYY-MM"` or `"YYYY"` |
| `end_date` | `string \| null` | Yes | `"YYYY-MM"`, `"YYYY"`, or `null` |
| `is_current` | `boolean` | Yes | `true` if currently enrolled |
| `grade` | `string \| null` | No | Optional CGPA / distinction (omit or `null` if private) |
| `coursework` | `string[]` | No | Relevant courses (e.g., `"Human-Computer Interaction"`, `"Web Application Development"`) |
| `achievements` | `string[]` | No | Dean's List, hackathon awards, scholarships |

### Example

```json
[
  {
    "id": "utem-bcs",
    "institution": "Universiti Teknikal Malaysia Melaka (UTeM)",
    "degree": "Bachelor of Computer Science",
    "faculty": "Faculty of Information and Communication Technology (FTMK)",
    "location": "Melaka, Malaysia",
    "start_date": "2024-10",
    "end_date": "2028-06",
    "is_current": true,
    "grade": null,
    "coursework": [
      "Human-Computer Interaction",
      "Web Application Development",
      "Software Engineering"
    ],
    "achievements": []
  }
]
```

---

## 4. `data/photography.json`

Represents curated photography showcase items.

| Field | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `id` | `string` | Yes | Unique kebab-case slug |
| `title` | `string` | Yes | Short title for the photo |
| `caption` | `string` | No | Story or context shown beneath/in lightbox |
| `alt` | `string` | Yes | Descriptive alt text for accessibility |
| `src` | `string` | Yes | Relative path under `asset/` (e.g., `"asset/photography/street-01.webp"`) |
| `category` | `string` | Yes | e.g., `"Street"`, `"Architecture"`, `"Landscape"`, `"Portrait"`, `"Campus"` |
| `location` | `string` | No | Where it was captured |
| `date` | `string` | Yes | `"YYYY-MM-DD"` or `"YYYY-MM"` |
| `camera` | `string \| null` | No | Optional camera/lens info |
| `aspect_ratio` | `string` | No | `"4/3"`, `"3/2"`, `"4/5"`, `"1/1"`, or `"16/9"` |
| `featured` | `boolean` | Yes | `true` to show in homepage gallery preview |

### Example

```json
[
  {
    "id": "melaka-river-dusk",
    "title": "Dusk Along Melaka River",
    "caption": "Warm reflections over the canal just after sunset.",
    "alt": "Calm river reflecting warm golden streetlamps and shophouses at dusk in Melaka",
    "src": "asset/photography/melaka-river-dusk.webp",
    "category": "Street",
    "location": "Melaka, Malaysia",
    "date": "2026-05-14",
    "camera": null,
    "aspect_ratio": "4/3",
    "featured": true
  }
]
```
