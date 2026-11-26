# Design Tokens & Component Recipes (Tailwind CSS v4)

All tokens below match the clean Slate + Indigo aesthetic initialized in `header.php`.

## Color System

| Role | Light Surface Class | Text / Ink Class | Contrast & Usage Notes |
| :--- | :--- | :--- | :--- |
| Page Canvas | `bg-white` | `text-slate-900` | Primary background; high contrast (> 15:1) |
| Alternate Band | `bg-slate-50` | `text-slate-900` | Visual separation between adjacent sections |
| Card Surface | `bg-white` | `text-slate-900` | Pair with `border border-slate-200/80 shadow-xs` |
| Body Copy | — | `text-slate-600` | Meets WCAG AA (> 7:1 on white/slate-50) |
| Muted Meta | — | `text-slate-500` | Dates, locations, secondary captions (≥ 4.5:1 on white) |
| Primary Accent | `bg-indigo-600 hover:bg-indigo-700` | `text-white` | Primary CTA buttons (≥ 4.5:1) |
| Accent Tint | `bg-indigo-50` | `text-indigo-700` | Category pills, active filter chips, badges |
| Focus Ring | — | `focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600` | Required on all links and buttons |

## Layout & Spacing Rhythm

- **Page Container**: `mx-auto max-w-6xl px-4 sm:px-6 lg:px-8`
- **Section Padding**: `py-16 sm:py-20 lg:py-24`
- **Sticky Header Offset**: `scroll-mt-20` on every `<section id="...">`
- **Grid Columns**:
  - Projects: `grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3`
  - Photography: `grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3`
  - Experience / Education timeline: `space-y-6` inside `max-w-3xl` or two-column split (`lg:grid-cols-12`)

## Typography Scale

- **Eyebrow / Section Kicker**: `text-xs font-semibold uppercase tracking-wider text-indigo-600`
- **Hero H1**: `text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl`
- **Section H2**: `text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl`
- **Card / Entry H3**: `text-lg font-semibold text-slate-900`
- **Lead Paragraph**: `text-lg leading-relaxed text-slate-600`
- **Standard Body**: `text-sm leading-6 text-slate-600` (or `text-base leading-7` for long-form About text)

## Copy-Ready Component Patterns

### Section Header
```html
<div class="mb-10 max-w-2xl">
    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Selected Work</p>
    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Projects &amp; Case Studies</h2>
    <p class="mt-3 text-base leading-relaxed text-slate-600">
        Human-centered interfaces, usability studies, and full-stack prototypes.
    </p>
</div>
```

### Buttons
```html
<!-- Primary -->
<a href="#contact" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow-xs transition-colors hover:bg-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
    Get in Touch
</a>

<!-- Secondary -->
<a href="#projects" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
    View Projects
</a>
```

### Project Card
```html
<article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xs transition-shadow hover:shadow-md">
    <div class="aspect-video w-full overflow-hidden bg-slate-100">
        <img src="asset/projects/example.webp" alt="Descriptive alt text" loading="lazy"
             class="h-full w-full object-cover transition-transform duration-300 motion-safe:group-hover:scale-105" />
    </div>
    <div class="flex flex-1 flex-col p-6">
        <div class="flex items-center justify-between gap-2 text-xs">
            <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 font-medium text-indigo-700">HCI / UX</span>
            <span class="text-slate-500">2026</span>
        </div>
        <h3 class="mt-3 text-lg font-semibold text-slate-900">Project Title</h3>
        <p class="mt-2 flex-1 text-sm leading-6 text-slate-600">Short concise summary of problem and outcome.</p>
        <ul class="mt-4 flex flex-wrap gap-1.5" aria-label="Technologies and methods">
            <li class="rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700">Figma</li>
        </ul>
    </div>
</article>
```

### Empty State Card
```html
<div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 p-10 text-center">
    <p class="text-sm font-medium text-slate-700">No items added yet.</p>
    <p class="mt-1 text-sm text-slate-500">Add entries to <code class="rounded bg-slate-200/70 px-1.5 py-0.5 text-xs text-slate-800">data/project.json</code> to display them here.</p>
</div>
```
