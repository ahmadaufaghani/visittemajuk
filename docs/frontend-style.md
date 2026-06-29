# Frontend Style Guide

The public frontend uses Blade, Tailwind CSS, Alpine.js, and Livewire-ready assets. The `design` branch provides the static website design reference, while `dev` contains the Laravel implementation and reusable styling primitives.

## Tailwind Setup

Tailwind CSS 4 is configured through `resources/css/app.css` using CSS-first `@theme` tokens.

Source scanning includes:

- Laravel pagination views,
- compiled framework views,
- `resources/views/**/*.blade.php`,
- `app/Livewire/**/*.php`,
- `app/Filament/**/*.php`.

## Design Tokens

Core token groups include:

- fonts: `--font-sans`, `--font-display`,
- colors: brand, accent, surface, card, ink, muted, border, and primary colors,
- radius: card and control radius,
- shadows: card, hover, soft, and accent shadows,
- motion: `--ease-standard`,
- text scale: page title, section title, and body copy,
- layout spacing: container width, gutters, section spacing, card gap, and section header gap.

Use these tokens before creating one-off color, radius, shadow, or spacing values.

## Reusable Component Classes

Use existing component classes for repeated patterns:

- containers: `.app-container`, `.app-container-wide`,
- sections: `.section`, `.section-compact`, `.section-header`,
- typography: `.page-title`, `.section-title`, `.section-description`,
- buttons: `.btn`, `.btn-primary`, `.btn-accent`, `.btn-secondary`, `.btn-ghost`,
- cards: `.card`, `.content-card`, `.content-card-body`, `.card-action`,
- badges: `.badge`, `.badge-place`, `.badge-stay`, `.badge-story`,
- forms: `.form-label`, `.form-input`, `.form-help`,
- navigation: `.site-header`, `.header-bar`, `.brand-mark`, `.site-nav`, `.nav-link`,
- carousel: `.carousel`, `.carousel-track`, `.carousel-slide`, `.carousel-control`, `.carousel-status`,
- pagination: `.pagination`, `.pagination-button`, `.pagination-status`,
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

Use Alpine.js for small local interactions such as toggles, tabs, dropdowns, and lightweight UI state.

Use Livewire for server-driven interactivity that needs validation, persistence, filtering, or database-backed updates.

Keep large or server-driven workflows in Livewire or regular Laravel controllers instead of global Alpine scripts.

## Design Drift Prevention

- Check `resources/css/app.css` before adding new colors or component classes.
- Keep new UI primitives consistent with existing token names and component patterns.
- Keep static HTML, CSS, JavaScript, and assets in `design`; implement public pages in Laravel.
- Use `design` as the visual reference while implementing public pages in Laravel.
