# PORTFOLIO HCI — Workspace Agent Rules

## Project Overview

This is a personal **Human-Computer Interaction (HCI) Portfolio** web application built with vanilla PHP, Tailwind CSS v4 (browser CDN), and flat-file JSON datasets.

### Stack & Structure

- **Runtime**: Vanilla PHP (no framework, no build step).
- **Styling**: Tailwind CSS v4 loaded via `@tailwindcss/browser@4` in `header.php`.
- **Entry & Partials**:
  - `index.php` — Main portfolio landing page.
  - `header.php` — Shared document head and sticky responsive navigation bar.
- **Data**: Flat-file JSON stored in `data/`:
  - `data/project.json` — Software, UI/UX, and HCI projects / case studies.
  - `data/experience.json` — Work, internship, and organization experience.
  - `data/education.json` — Academic background and coursework.
  - `data/photography.json` — Photography showcase items.
- **Assets**: Local images, icons, and downloadable files (e.g., resume PDF) in `asset/`.

## Skill Routing

Always read and follow the matching workspace skill before modifying related files:

- **`.agents/skills/data-query/SKILL.md`**: Activate when creating, editing, validating, or querying any `data/*.json` file, or when writing PHP loaders/filters/rendering helpers for portfolio data.
- **`.agents/skills/project-design/SKILL.md`**: Activate when designing, styling, refactoring, or auditing UI components, page layouts, Tailwind CSS v4 classes, responsive behavior, or HCI / WCAG accessibility.

## Always-On Engineering Guardrails

1. **Valid Single-Document HTML**: Ensure each rendered PHP page outputs exactly one `<!DOCTYPE html>`, `<html>`, `<head>`, and `<body>`. When refactoring `header.php` / `footer.php` partials, keep opening `<body>` in `header.php` and closing `</body></html>` in `footer.php` (never nest or duplicate `<body>` tags in `index.php`).
2. **XSS-Safe PHP Output**: Escape every dynamic string from JSON before rendering in HTML using `htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')`. Validate external and local URLs before inserting them into `href` or `src` attributes (allow only `https://`, `http://`, `mailto:`, `#`, `/`, or relative `asset/` paths).
3. **Graceful Empty-Data Handling**: Any `data/*.json` file may temporarily be empty (`0` bytes) or contain `[]`. PHP loaders must fail safely to an empty array and the UI must render a clean empty state rather than PHP warnings or broken layouts.
4. **JSON Hygiene**: Keep all `data/*.json` files valid UTF-8 JSON formatted with 2-space indentation, double quotes, and no trailing commas.
5. **Authentic Content**: Never invent real personal details (GPA, employer names, dates, contact info) silently. If personal data is missing, either ask the user or mark sample entries clearly as placeholders.
6. **HCI & Accessibility Baseline**: Every interactive element must be keyboard-accessible with visible `focus-visible` states, images must include descriptive `alt` text, and color contrast must meet WCAG 2.1 AA.
