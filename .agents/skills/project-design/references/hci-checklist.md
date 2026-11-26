# HCI Usability & WCAG 2.1 AA Checklist

Use this rubric whenever designing, implementing, or reviewing portfolio pages and components.

## 1. Nielsen's Usability Heuristics (Portfolio Context)

1. **Visibility of System Status**:
   - Highlight active navigation links and active category filters (`aria-current="page"` / `aria-pressed="true"`).
   - Provide clear visual feedback on hover, focus, active press, and form/filter transitions.
2. **Match Between System and the Real World**:
   - Use plain, natural section titles (`About`, `Projects`, `Experience`, `Education`, `Photography`, `Contact`) and human-readable dates (`Mar 2026 – Present`).
3. **User Control and Freedom**:
   - Modals / photography lightboxes must close via an explicit Close button, `Escape` key, and backdrop click, restoring focus to the triggering element.
   - Mobile navigation menu closes when a section link is clicked or `Escape` is pressed.
4. **Consistency and Standards**:
   - Keep button shapes (`rounded-lg`), card radii (`rounded-2xl`), accent color (`indigo-600`), and heading cadence uniform across every section.
   - Ensure navigation links in `header.php` match the exact `id` attributes in `index.php`.
5. **Error Prevention**:
   - Guard against missing or empty JSON files and missing local images gracefully.
   - Open external links safely (`target="_blank" rel="noopener noreferrer"`) with an accessible cue when opening a new tab.
6. **Recognition Rather Than Recall**:
   - Display concise role, year, and method/tech tags directly on project cards so visitors can scan without clicking every item.
7. **Flexibility and Efficiency of Use**:
   - Provide a keyboard skip-to-content link as the first focusable element in `<body>`.
   - Keep key recruiter actions (`Resume`, `Contact` / `Hire Me`) reachable from the sticky header.
8. **Aesthetic and Minimalist Design**:
   - Avoid cluttered badges (cap card tags at 3–5 concise chips).
   - Prioritize whitespace, readable line length (`max-w-prose` / `65ch` for paragraphs), and clear focal points.

## 2. WCAG 2.1 AA Technical Checklist

### Perceivable
- [ ] Normal text contrast ≥ `4.5:1`; large text (≥ 18pt / 14pt bold) and UI boundaries ≥ `3:1`.
- [ ] Do not convey state (active tab, error, category) by color alone—pair with weight, underline, icon, or label.
- [ ] Every meaningful `<img>` has descriptive `alt`; purely decorative SVGs have `aria-hidden="true"`.

### Operable
- [ ] Full keyboard navigation (`Tab`, `Shift+Tab`, `Enter`, `Space`, `Escape`) with no keyboard traps.
- [ ] Visible `:focus-visible` indicator on every interactive element (never `outline-none` without a replacement ring).
- [ ] Touch targets at least `40px × 40px` (`44px` preferred) on mobile buttons and links.
- [ ] Respect `prefers-reduced-motion` on hover scales, smooth scrolling, and reveal transitions.

### Understandable
- [ ] `<html lang="en">` set correctly; unique, descriptive `<title>` per page.
- [ ] Logical heading hierarchy: one `<h1>`, followed by `<h2>` section headers and `<h3>` card/entry titles without skipping levels.
- [ ] Clear, descriptive link text (avoid bare "Click here" or "Read more"—use "View Live Demo" or include `sr-only` project context).

### Robust
- [ ] Single valid HTML5 document (no duplicate `<body>`, `<head>`, or `</html>` from PHP includes).
- [ ] Semantic landmarks used properly: `<header>`, `<nav aria-label="...">`, `<main id="main-content">`, `<section aria-labelledby="...">`, `<footer>`.
- [ ] Interactive toggles maintain accurate ARIA attributes (`aria-expanded`, `aria-controls`).
