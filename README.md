# Visit Temajuk Laravel Application

Visit Temajuk is a Laravel application for a team-managed tourism CMS and public website. The repository contains the application structure, tooling, database schema, admin resources, frontend styling primitives, and collaboration workflow used by the development team.

Authored website content, local environment values, generated dependency folders, and deployment secrets are managed through their dedicated runtime, CMS, and infrastructure workflows rather than versioned in source control.

## Branch Strategy

- `dev`: primary Laravel application development branch.
- `design`: static website design reference.
- `dev_*`: personal development branches that may open pull requests into `dev`.

The `dev` branch contains the Laravel application. The `design` branch contains the static website design reference and must not include application dependencies, backend configuration, or generated build artifacts.

## Requirements

- PHP 8.3+
- Composer 2+
- Node.js 22.12+ and npm; Node.js 24 is used by GitHub Actions
- MySQL 8+ or compatible database for local development
- Git

Composer resolves the dependency lock against PHP 8.3 through `config.platform.php` so the lock file stays compatible with the GitHub Actions runtime and the minimum supported PHP version.

## Stack

- Laravel 13
- Blade
- Tailwind CSS 4
- Alpine.js
- Livewire 4
- Filament 5
- MySQL
- Pest
- Laravel Pint
- Larastan / PHPStan
- Prettier
- Husky, lint-staged, Commitlint

## Setup

Clone the repository and install dependencies:

```bash
git clone <repository-url>
cd visittemajuk
composer install
npm install
```

Create the local environment file:

```bash
cp .env.example .env
php artisan key:generate
```

Configure the database values in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=visittemajuk
DB_USERNAME=root
DB_PASSWORD=
```

Apply the database schema and prepare local assets:

```bash
php artisan migrate
php artisan storage:link
npm run build
```

Application content is managed through database and admin workflows. `DatabaseSeeder` is limited to approved system data and is not a source for authored website content or design-reference imports.

## Environment Files

- `.env.example`: local development environment template.
- `.env.production.example`: production environment template for deployment planning.
- `.env.testing`: test environment using SQLite in-memory database.

Never commit real `.env` files, credentials, API keys, database dumps, or production secrets.

Localization defaults are configured through:

```env
APP_LOCALE=id
APP_SUPPORTED_LOCALES=id,en
APP_FALLBACK_LOCALE=id
```

## Development Commands

| Command                     | Purpose                                                                                                                                       |
| --------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------- |
| `composer setup`            | Install dependencies, create `.env` when missing, generate app key, run migrations, link storage, install npm dependencies, and build assets. |
| `composer dev`              | Run Laravel server, queue listener, log tailing, and Vite together.                                                                           |
| `composer dev:server`       | Run only the Laravel development server.                                                                                                      |
| `npm run dev`               | Run Vite development server.                                                                                                                  |
| `npm run build`             | Build frontend assets.                                                                                                                        |
| `php artisan migrate`       | Apply database migrations.                                                                                                                    |
| `php artisan migrate:fresh` | Rebuild the local database schema from scratch.                                                                                               |
| `php artisan storage:link`  | Link public storage for uploaded media.                                                                                                       |

Use `composer dev` for normal local development. Use separate commands when debugging one process at a time.

## Quality Commands

| Command                     | Purpose                                                                  |
| --------------------------- | ------------------------------------------------------------------------ |
| `composer test`             | Clear config cache and run Pest.                                         |
| `composer test:coverage`    | Run Pest with coverage reporting when coverage support is available.     |
| `composer format`           | Format PHP with Laravel Pint.                                            |
| `composer format:check`     | Check PHP formatting without writing changes.                            |
| `composer analyse`          | Run Larastan / PHPStan.                                                  |
| `composer quality:backend`  | Run Pint check, PHPStan, and Pest.                                       |
| `composer quality:frontend` | Run Prettier check and Vite build.                                       |
| `composer quality`          | Run backend and frontend quality gates.                                  |
| `npm run format`            | Format frontend, Blade, JSON, Markdown, and related files with Prettier. |
| `npm run format:check`      | Check Prettier formatting without writing changes.                       |
| `npm run lint-staged`       | Run lint-staged on staged files.                                         |

Run this before opening a pull request:

```bash
composer quality
```

## Git Hooks

Husky hooks are installed by `npm install` through the `prepare` script.

- `pre-commit`: runs `npx lint-staged`.
- `commit-msg`: runs `npx --no-install commitlint --edit "$1"`.
- `pre-push`: runs `composer quality`.

Commit messages must use:

```text
type(context): message
```

Example:

```text
feat(cms): add place media relationship
```

## GitHub Workflow

GitHub automation is defined under `.github`.

- `ci.yml`: runs Pest, Laravel Pint check, Larastan/PHPStan, Prettier check, and Vite build.
- `commitlint.yml`: validates pull request commit messages.
- `dependency-review.yml`: reviews dependency changes in pull requests when the repository supports GitHub Dependency Review.

The committed workflow set covers CI, commit message validation, and dependency change review. Dependency version updates are handled through reviewed pull requests. Production deployment automation is managed separately from these local quality workflows, and the repository uses `dev` as the primary branch.

Remote repository settings such as branch protection, security toggles, labels, and GitHub Projects must be configured manually. See [GitHub Setup Guide](docs/github-setup.md).

## Project Structure

- `app/Models`: Eloquent models and relationships.
- `app/Http/Controllers`: Laravel controllers.
- `app/Http/Middleware`: HTTP middleware such as locale handling.
- `app/Filament/Resources`: Filament CMS CRUD resources.
- `database/migrations`: database schema.
- `database/seeders`: seed entrypoint for approved system data.
- `resources/views`: Blade views and components.
- `resources/css/app.css`: Tailwind tokens and reusable UI primitives.
- `resources/js/app.js`: Livewire ESM startup and reusable Alpine component registrations.
- `.github/workflows`: local GitHub Actions workflow definitions.
- `docs`: project documentation for GitHub setup, database/localization, frontend styling, and troubleshooting.

Keep the project close to standard Laravel MVC. Introduce `Services`, `Actions`, `Repositories`, or other custom architecture folders only when repeated implementation complexity proves they are needed.

## Database and Localization

The CMS schema supports content, media, navigation, categories, and multilingual fields for application features. Translated content is stored in separate translation tables such as `place_translations`, not duplicated columns like `title_id`, `title_en`, `description_id`, or `description_en`.

Content records and locale data are managed through application and admin workflows.

See [Database and Localization](docs/database-localization.md).

## Frontend Styling

Tailwind setup uses CSS-first tokens and reusable component classes in `resources/css/app.css`. The styling system follows the direction of the `design` branch while keeping implementation in Laravel Blade, Alpine components, and Livewire-ready assets.

See [Frontend Style Guide](docs/frontend-style.md).

## Public Routes and Admin

Public application routes:

- `/`
- `/id`
- `/en`

Filament admin is available at:

```text
/admin
```

For local development, any authenticated user can access the admin panel. In non-local environments, users must have `is_admin=true`.

## Troubleshooting

See [Troubleshooting](docs/troubleshooting.md) for common setup, database, Vite, formatting, and test issues.

## Contributing

See [Contributing Guide](CONTRIBUTING.md) for branch naming, commit convention, coding standards, testing, formatting, review flow, and pull request expectations.
