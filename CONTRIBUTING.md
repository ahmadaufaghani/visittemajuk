# Contributing Guide

## Branch Naming

Use short, descriptive branch names:

- `feat/context-short-description`
- `fix/context-short-description`
- `chore/context-short-description`
- `docs/context-short-description`
- `test/context-short-description`

Main project branches are reserved:

- `dev`
- `design`

## Commit Convention

Use:

```text
type(context): message
```

Allowed types:

- `build`
- `chore`
- `ci`
- `docs`
- `feat`
- `fix`
- `perf`
- `refactor`
- `revert`
- `style`
- `test`

Example:

```text
feat(setup): initialize Laravel boilerplate
```

## Laravel Structure

- Keep controllers focused on request handling.
- Put persistence and relationships in Eloquent models.
- Use Form Request classes when validation grows beyond simple controller-level needs.
- Keep migrations explicit, reversible, and named after the schema change.
- Keep Blade files in kebab-case.
- Do not introduce `Services`, `Actions`, or `Repositories` until repeated complexity proves they are needed.

## Blade and Tailwind

- Prefer Blade components for repeated UI.
- Use the Tailwind primitives in `resources/css/app.css` before inventing new component classes.
- Use utility classes for one-off layout changes, and use the existing component classes for repeated buttons, cards, badges, nav links, forms, carousel controls, pagination, and accordions.
- Keep public UI colors aligned with the forest, warm surface, and orange accent tokens from the `design` branch.
- Keep responsive behavior mobile-first.
- Include visible focus states for interactive elements.
- Avoid copying static website implementation into `dev`; the static reference belongs in `design`.

## Alpine.js

- Use Alpine only for small UI interactions.
- Keep component state local.
- Move complex dynamic behavior to Livewire instead of growing large Alpine scripts.

## Livewire

- Use Livewire for interactive server-driven UI.
- Keep components focused on one user interaction.
- Validate Livewire input server-side.
- Avoid using Livewire for static content rendering.

## Filament

- Use Filament resources for CRUD scaffolding.
- Keep resource forms aligned with database schema and model relationships.
- Store multilingual content through translation relationships.
- Do not seed production-like content from Filament examples or static reference files.

## Testing

- Add or update Pest tests when changing routing, schema behavior, model relationships, middleware, or admin access rules.
- Use `RefreshDatabase` for feature tests that touch the database.
- Keep tests deterministic and independent of seeded data.

## Formatting and Analysis

Run before opening a pull request:

```bash
composer quality
```

Use `composer format` and `npm run format` to fix formatting.

## Pull Request Workflow

- Keep pull requests small enough to review.
- Explain what changed and why.
- Include screenshots only when UI behavior changes.
- Mention migration impact when schema changes.
- Confirm relevant tests and build commands have passed.
