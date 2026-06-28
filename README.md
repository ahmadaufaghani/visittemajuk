# Visit Temajuk Laravel Boilerplate

This branch is the Laravel boilerplate for Visit Temajuk. It is intentionally limited to project setup, tooling, schema, admin scaffolding, and frontend styling primitives. It does not contain final website content, static website files, or seeded application data.

## Branches

- `dev`: Laravel boilerplate used by the development team.
- `design`: static website reference only.

The `dev` branch must not contain static reference files. The `design` branch must not contain the Laravel project, Composer dependencies, Node dependencies, or backend configuration.

## Requirements

- PHP 8.3+
- Composer 2+
- Node.js 22+ and npm
- MySQL 8+ or compatible

## Stack

- Laravel 13
- Blade, Tailwind CSS 4, Alpine.js
- Livewire 4
- Filament 5
- Pest
- Laravel Pint
- Larastan/PHPStan
- Prettier
- Husky, lint-staged, Commitlint

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run build
```

The database is schema-only at this stage. Do not run seeders to add project content. `DatabaseSeeder` is intentionally empty.

## Environment

Copy `.env.example` to `.env`, then configure:

- `APP_URL`
- `APP_LOCALE`
- `APP_SUPPORTED_LOCALES`
- MySQL connection variables
- mail settings if needed

Use `.env.production.example` as a production template. Never commit real credentials or generated `.env` files.

## Development Commands

```bash
composer dev
composer dev:server
npm run dev
npm run build
```

`composer dev` runs Laravel, queue listener, log tailing, and Vite together. Use `composer dev:server` and `npm run dev` separately when debugging one process at a time.

## Quality Commands

```bash
composer test
composer test:coverage
composer format
composer format:check
composer analyse
composer quality:backend
composer quality:frontend
composer quality
npm run format
npm run format:check
npm run lint-staged
```

`composer quality` runs the backend checks, frontend formatting check, and Vite build.

## Git Hooks

Husky hooks are installed through `npm install` / `npm run prepare`.

- `pre-commit`: runs `lint-staged`.
- `commit-msg`: validates commit messages with Commitlint.
- `pre-push`: runs `composer quality`.

Commit messages must use:

```text
type(context): message
```

Example:

```text
feat(setup): initialize Laravel boilerplate
```

## Project Structure

- `app/Models`: Eloquent models and relationships.
- `app/Http/Controllers`: Laravel controllers.
- `app/Http/Middleware`: HTTP middleware such as locale handling.
- `app/Filament/Resources`: CMS CRUD scaffolding.
- `database/migrations`: database schema.
- `database/seeders`: intentionally empty seed entrypoint.
- `resources/views`: Blade boilerplate views and components.
- `resources/css/app.css`: Tailwind tokens and reusable UI primitives.
- `resources/js/app.js`: Alpine initialization and small generic interactions.

Keep the project close to standard Laravel MVC. Do not add `Services`, `Actions`, `Repositories`, or custom architecture folders until there is a concrete need.

## Database and Localization

The migration set prepares the CMS schema for content, media, navigation, categories, and multilingual fields. Translated content is stored in separate translation tables such as `place_translations`, not duplicated columns like `title_id` or `title_en`.

No database data is inserted by default. Locale rows can be created later through Filament or a future explicit system-data seed decision.

## Frontend Boilerplate

Tailwind setup includes:

- Tailwind CSS 4 using the CSS-first `@theme` approach,
- color, typography, radius, shadow, motion, spacing, and container tokens aligned with the `design` branch static reference,
- `.app-container`, `.app-container-wide`, `.section`, `.section-compact`, and `.section-header`,
- `.btn`, `.btn-primary`, `.btn-accent`, `.btn-secondary`, and `.btn-ghost`,
- `.card`, `.content-card`, `.content-card-body`, and `.card-action`,
- `.badge`, status badge variants, navigation links, form controls, carousel controls, pagination controls, and accordion primitives,
- default focus-visible, disabled, hover, active, responsive, and reduced-motion states.

These are starter primitives, not a final design system and not the static website implementation.

## Admin

Filament is available at:

```text
/admin
```

For local development, any authenticated user can access the admin panel. In non-local environments, users must have `is_admin=true`.

## Contributing

See `CONTRIBUTING.md` for branch naming, commit, coding, testing, formatting, and pull request conventions.
