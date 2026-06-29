# Contributing Guide

This guide defines how the team works on the Visit Temajuk Laravel application. Treat every change as part of a long-lived project that is developed, reviewed, tested, and maintained by the team.

## Branch Naming

Use short, descriptive branch names:

- `feat/context-short-description`
- `fix/context-short-description`
- `chore/context-short-description`
- `docs/context-short-description`
- `test/context-short-description`
- `dev_name` for personal development branches when the team intentionally uses that convention

Project branches:

- `dev`: Laravel application development branch.
- `design`: static website design reference.

Laravel application code belongs in `dev`. Static website reference files belong in `design`.

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

Examples:

```text
feat(cms): add place media relationship
ci(github): add local quality workflows
docs(setup): clarify environment configuration
```

Commitlint enforces a non-empty scope and the allowed type list.

## Pull Request Workflow

- Open pull requests into `dev`, not `design`.
- Keep pull requests small enough to review.
- Explain what changed and why.
- Mention migration impact when schema changes.
- Include screenshots or screen recordings when UI behavior changes.
- Confirm that no secrets, `.env` values, local paths, dependency directories, caches, or generated build files are included.
- Wait for relevant GitHub checks to pass before requesting merge:
    - `quality`
    - `commitlint`
    - `dependency-review` where repository settings support it
- Resolve review comments and conversations before merge.
- Prefer squash merge for a clean branch history.

Recommended local verification before opening a pull request:

```bash
composer quality
```

Remote GitHub settings are documented in [GitHub Setup Guide](docs/github-setup.md).

## Laravel Structure

- Keep controllers focused on request handling.
- Put persistence, casts, scopes, and relationships in Eloquent models.
- Use Form Request classes when validation grows beyond simple controller-level needs.
- Keep migrations explicit, reversible, and named after the schema change.
- Keep Blade files in kebab-case.
- Keep Livewire components focused on a single interactive concern.
- Keep Filament resources aligned with database schema and model relationships.
- Introduce `Services`, `Actions`, `Repositories`, or custom architecture folders only when repeated complexity proves they are needed.

## Database and Localization

- Use migrations as the source of truth for schema changes.
- Limit seeders to approved system data; authored website content and design-reference data belong in admin and application workflows.
- Store multilingual content in translation tables, not duplicated language-specific columns.
- Use `locale_code` relationships and the `HasTranslations` helper pattern already present in the models.
- Keep slug uniqueness scoped by locale for translated public content.
- Add or update tests when changing schema, translation behavior, or model relationships.

See [Database and Localization](docs/database-localization.md).

## Blade and Tailwind

- Prefer Blade components for repeated UI.
- Use Tailwind primitives in `resources/css/app.css` before creating new component classes.
- Use utility classes for one-off layout changes.
- Use existing component classes for repeated buttons, cards, badges, navigation links, forms, carousel controls, pagination, and accordions.
- Keep public UI colors aligned with the forest, warm surface, and orange accent tokens from the `design` branch.
- Keep responsive behavior mobile-first.
- Include visible focus states for interactive elements.
- Keep static website implementation files in `design`; `dev` uses the branch as a visual reference for Laravel implementation.

See [Frontend Style Guide](docs/frontend-style.md).

## Alpine.js

- Use Alpine only for small UI interactions.
- Keep component state local.
- Avoid large global Alpine scripts.
- Move complex server-driven interactivity to Livewire.

## Livewire

- Use Livewire for interactive server-driven UI.
- Keep components focused on one workflow.
- Validate Livewire input server-side.
- Avoid using Livewire for static content rendering.

## Filament

- Use Filament resources for CMS CRUD.
- Store multilingual content through translation relationships.
- Keep status, ordering, featured state, media, and SEO fields manageable from admin forms when the schema supports them.
- Use Filament examples for implementation guidance only; authored content belongs to admin and database workflows.

## Testing

- Add or update Pest tests when changing routing, schema behavior, model relationships, middleware, localization, or admin access rules.
- Use `RefreshDatabase` for feature tests that touch the database.
- Keep tests deterministic and independent of authored content.
- Use `.env.testing` for local and CI tests.

Commands:

```bash
composer test
composer test:coverage
```

## Formatting and Analysis

Use the project tools instead of editor-specific formatting.

```bash
composer format
composer format:check
composer analyse
npm run format
npm run format:check
composer quality
```

Quality tools:

- Pest: test runner.
- Laravel Pint: PHP formatter.
- Larastan / PHPStan: static analysis.
- Prettier: frontend, Blade, JSON, Markdown, and GitHub workflow formatting.
- Husky: local Git hooks.
- lint-staged: staged-file formatting for commits.
- Commitlint: commit message validation.

## Repository Exclusions

Keep these files and directories out of commits:

- `.env` or real credentials,
- `vendor/`,
- `node_modules/`,
- `public/build/`,
- `public/storage/`,
- local SQLite databases,
- cache/log files,
- IDE folders,
- static design reference files in `dev`.

The repository `.gitignore` already covers the common generated and local-only paths.
