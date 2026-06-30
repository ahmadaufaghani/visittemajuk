# Frontend Style Guide

The public frontend uses Blade, Tailwind CSS, Alpine.js, and Livewire. The `design` branch provides the static website design reference, while `dev` contains the Laravel implementation and reusable styling primitives.

## Tailwind Setup

Tailwind CSS 4 is configured through `resources/css/app.css` using CSS-first `@theme` tokens and `@layer` component classes.

Source scanning includes:

- Laravel pagination views,
- compiled framework views,
- `resources/views/**/*.blade.php`,
- `app/Livewire/**/*.php`,
- `app/Filament/**/*.php`.

## Design Tokens

Core tokens intentionally mirror the static reference names where practical:

- fonts: `--font-sans`, `--font-display`,
- colors: `--brand`, `--brand-deep`, `--accent-orange`, `--surface`, `--card`, `--ink`, and Tailwind `--color-*` aliases,
- radius: card and control radius,
- shadows: card, hover, soft, and accent shadows,
- motion: `--ease-standard`,
- text scale: page title, section title, and body copy,
- layout spacing: container width, gutters, section spacing, card gap, and section header gap.

Use these tokens before creating one-off color, radius, shadow, or spacing values.

## Reusable Component Classes

Use existing component classes for repeated patterns:

- containers: `.container`,
- sections: `.section`, `.section-compact`, `.section-header`,
- typography: `.page-title`, `.section-intro`, `.section-description`, `.eyebrow-row`,
- buttons: `.button`, `.button-dark`, `.button-orange`, `.button-outline`, `.button-ghost-light`,
- cards: `.card`, `.content-card`, `.card-body`, `.card-action`,
- badges: `.category-badge`, `.category-place`, `.category-stay`, `.category-story`,
- forms: `.form-label`, `.form-input`, `.form-help`,
- navigation: `.site-header`, `.header-inner`, `.brand`, `.desktop-nav`, `.mobile-nav`,
- carousel: `.carousel`, `.carousel-track`, `.carousel-slide`, `.carousel-control`, `.carousel-status`,
- pagination: `.pagination`, `.pagination-status`,
- accordion: `.accordion-list`, `.accordion-item`, `.accordion-trigger`, `.accordion-panel`.

## Utility Class Convention

Use Tailwind utility classes for one-off layout adjustments. Promote repeated patterns into component classes only when reuse is clear.

Avoid creating page-specific styling that duplicates an existing primitive. Prefer improving the primitive when multiple screens need the same behavior.

## Responsive and Accessibility Rules

- Design mobile-first.
- Keep focus-visible states for all interactive controls.
- Preserve disabled states for buttons and inputs.
- Respect reduced-motion behavior when adding interactions.
- Avoid text that overflows buttons, cards, or compact controls.
- Keep public UI aligned with the forest, warm surface, and orange accent direction from the `design` branch.

## Alpine.js and Livewire

Use Alpine.js for small local interactions such as toggles, tabs, dropdowns, carousels, pagination controls, accordions, and lightweight UI state.

Use Livewire for server-driven interactivity that needs validation, persistence, filtering, or database-backed updates.

The project uses Livewire's ESM bundle in `resources/js/app.js`, registers custom Alpine components with `Alpine.data()`, and starts Livewire with `Livewire.start()`. Keep large or server-driven workflows in Livewire or regular Laravel controllers instead of global standalone scripts.

## Design Drift Prevention

- Check `resources/css/app.css` before adding new colors or component classes.
- Keep new UI primitives consistent with existing token names and component patterns.
- Keep static HTML, CSS, JavaScript, and assets in `design`; implement public pages in Laravel.
- Use `design` as the visual reference while implementing public pages in Laravel.
