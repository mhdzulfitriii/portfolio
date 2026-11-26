---
name: project-design
description: >-
  Use this skill when designing, building, styling, or reviewing any UI section,
  layout, component, responsive behavior, or HCI / WCAG accessibility aspect of
  this portfolio site (PHP templates, Tailwind CSS v4 classes, navigation, cards,
  galleries, and visual hierarchy).
---

# Portfolio UI & HCI Design System

This skill defines the visual identity, Tailwind CSS v4 conventions, layout architecture, and Human-Computer Interaction (HCI) standards for the portfolio.

## Core Design Direction

Anchor all new sections and components to the existing aesthetic established in `header.php`:

- **Theme**: Clean, modern light mode with high readability and generous whitespace.
- **Palette**:
  - Primary surfaces: `bg-white` and subtle alternating section bands `bg-slate-50`.
  - Primary text: `text-slate-900` (headings), `text-slate-600` (body), `text-slate-500` (metadata).
  - Brand accent: `indigo-600` (primary actions, active links, highlights) with `indigo-700` hover and `indigo-50` soft tints.
  - Borders & dividers: crisp hairlines `border-slate-200/80` or `border-slate-200`.
- **Header Cohesion**: Keep the sticky translucent header (`sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/80`) and add `scroll-mt-20` to every anchored `<section id="...">` so hash links never hide headings underneath the header.

For complete color tokens, typography scale, spacing rhythm, and copy-ready Tailwind v4 component patterns, read [design-tokens.md](./references/design-tokens.md).

## Workflow

### 1. Plan Page & Partial Structure
- Keep a single valid HTML5 document across PHP includes:
  - `header.php` opens `<!DOCTYPE html>`, `<html>`, `<head>`, `<body>`, skip link, and `<header>`.
  - `index.php` renders `<main id="main-content">` with semantic `<section>` landmarks (`#about`, `#projects`, `#experience`, `#education`, `#photography`, `#contact`).
  - `footer.php` renders `<footer>`, shared scripts, and closes `</body></html>`.
- Use one consistent container width across header, main sections, and footer: `mx-auto max-w-6xl px-4 sm:px-6 lg:px-8`.

### 2. Apply Tailwind CSS v4 CDN Rules
- Tailwind CSS v4 is loaded via `<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>` — do **not** assume a Node build step or `tailwind.config.js`.
- If custom theme tokens or utilities are needed, define them in a `<style type="text/tailwindcss">` block using `@theme { ... }` inside `header.php`.
- Prefer utility classes and responsive prefixes (`sm:`, `md:`, `lg:`) over custom CSS.
- Respect user motion preferences using `motion-safe:` / `motion-reduce:transition-none`.

### 3. Enforce HCI & Accessibility Standards
This is an **HCI portfolio**, so usability and accessibility are primary grading and showcase criteria. Before finishing any UI change, apply [hci-checklist.md](./references/hci-checklist.md):

- **Visual Hierarchy & Scannability**: One `<h1>` per page, strictly nested `<h2>` -> `<h3>` headings, clear primary vs. secondary CTAs, and concise scannable cards.
- **Feedback & Affordance**: Distinct `:hover`, `:focus-visible`, and `:active` states on every interactive element (`focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600`).
- **Empty & Error States**: When a `data/*.json` dataset is empty, render a helpful, styled empty-state card rather than a blank void.
- **Keyboard & Screen Reader Support**: Provide a skip-to-content link, maintain `aria-expanded` / `aria-controls` on toggles (like the mobile menu or filters), label icon-only buttons with `sr-only` or `aria-label`, and ensure every `<img>` has meaningful `alt` text.
- **Responsive Mobile-First Layout**: Verify layouts from 375px mobile through 1280px+ desktop without horizontal overflow.

### 4. Verify UI Changes
1. Confirm HTML validity (no duplicate `<body>` / `</html>`, single `<h1>`, matching anchor IDs between `header.php` nav links and `index.php` sections).
2. Confirm every interactive control has keyboard focus styles and accessible names.
3. Confirm images have explicit aspect ratios (`aspect-video`, `aspect-[4/3]`, etc.), `object-cover`, and `loading="lazy"` (except above-the-fold hero visuals).
4. Review against [hci-checklist.md](./references/hci-checklist.md).
