---
name: data-query
description: >-
  Use this skill whenever reading, authoring, updating, validating, or querying
  portfolio datasets in data/*.json (education.json, experience.json,
  photography.json, project.json), or when writing PHP helper functions that
  load, filter, sort, or safely render JSON data in this portfolio project.
---

# Portfolio Data Query & JSON Management

This skill standardizes how the PHP portfolio stores, loads, queries, validates, and safely renders data from `data/*.json`.

## Dataset Inventory

All structured portfolio content lives in `data/`:

| File | Purpose | Primary Sort Order |
| :--- | :--- | :--- |
| `data/project.json` | HCI, UI/UX, and software projects / case studies | `featured` desc, then `order` asc / `year` desc |
| `data/experience.json` | Work, internships, leadership, and volunteer roles | `is_current` desc, then `start_date` desc |
| `data/education.json` | Degrees, institutions, coursework, and honors | `is_current` desc, then `start_date` desc |
| `data/photography.json` | Photography gallery entries and metadata | `featured` desc, then `date` desc |

For exact field names, required keys, types, and sample records, read [schemas.md](./references/schemas.md).

## Workflow

### 1. Inspect Before Modifying
- Read the target `data/*.json` file first; note that newly initialized files may be empty (`0` bytes).
- Check `asset/` before referencing any local image or PDF path so no broken `src`/`href` links are introduced.

### 2. Follow Canonical Schemas
- Every dataset file MUST be a top-level JSON array (`[...]`), even when empty (`[]`).
- Every record MUST have a unique kebab-case `id` string (e.g., `"utem-hci-redesign"`).
- Use ISO date strings (`"YYYY-MM"` or `"YYYY-MM-DD"`), `null` for ongoing `end_date`, and relative paths starting with `asset/` for local media.
- Every image entry MUST include a meaningful `alt` string for WCAG accessibility.
- Consult [schemas.md](./references/schemas.md) for per-dataset fields before adding or renaming keys.

### 3. Load & Query Data Safely in PHP
- Centralize JSON reading and query logic in a reusable PHP helper (e.g., `includes/data.php`) rather than repeating `file_get_contents` + `json_decode` across templates.
- Resolve paths relative to `__DIR__` (never rely on current working directory).
- Treat missing, unreadable, or 0-byte JSON files as `[]` without emitting PHP notices or warnings.
- Use immutable array helpers (`array_values(array_filter(...))`, non-destructive sorting copies) for:
  - **Filtering**: by `category`, `featured`, `tags`, or keyword search.
  - **Sorting**: current/featured items first, then reverse chronological by `start_date` / `date` / `year`.
  - **Limiting**: slicing top N featured items for homepage previews.
- See [php-loader-pattern.md](./references/php-loader-pattern.md) for the reference PHP implementation.

### 4. Escape & Sanitize All Output
- Escape every JSON string rendered into HTML text or attributes via an `e()` helper wrapping `htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')`.
- Validate all URLs (`live_url`, `repo_url`, `image`, `src`) through a `safe_url()` helper that permits only `https://`, `http://`, `mailto:`, `#`, `/`, or relative `asset/` paths (blocking `javascript:` and `data:` URIs).

### 5. Validate Changes
After editing any `data/*.json` file or PHP data helper, run the validation script:

```powershell
powershell -ExecutionPolicy Bypass -File .agents/skills/data-query/scripts/validate_data.ps1
```

Confirm:
1. All 4 JSON files parse cleanly (or are explicitly reported if intentionally empty).
2. No duplicate `id` values exist within a dataset.
3. Required schema keys and `alt` attributes are present.
4. Referenced local `asset/` paths exist on disk.
5. If PHP is installed, PHP syntax checks (`php -l`) pass with zero errors.
