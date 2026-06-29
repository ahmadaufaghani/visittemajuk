# Troubleshooting

This guide covers common local setup and quality check issues.

## Composer Dependencies Missing

Symptom:

```text
vendor/autoload.php not found
```

Fix:

```bash
composer install
```

## Node Dependencies Missing

Symptom:

```text
vite: command not found
```

Fix:

```bash
npm install
```

Use `npm ci` in CI or when you want a clean install from `package-lock.json`.

## Missing Application Key

Symptom:

```text
No application encryption key has been specified.
```

Fix:

```bash
cp .env.example .env
php artisan key:generate
```

## Database Connection Fails

Check `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=visittemajuk
DB_USERNAME=root
DB_PASSWORD=
```

Then run:

```bash
php artisan migrate
```

The project expects MySQL for local development, while tests use SQLite in-memory through `.env.testing`.

## Public Storage Is Not Linked

Symptom: uploaded media paths do not resolve in public storage.

Fix:

```bash
php artisan storage:link
```

## Config Cache Uses Old Environment Values

Fix:

```bash
php artisan config:clear
```

The `composer test` script clears config before running Pest.

## Formatting Check Fails

PHP formatting:

```bash
composer format
```

Frontend, Blade, JSON, and Markdown formatting:

```bash
npm run format
```

Then rerun:

```bash
composer quality
```

## PHPStan Fails After Model Or Migration Changes

Run:

```bash
composer analyse
```

If the failure is related to a real type or relationship mismatch, fix the code instead of lowering the PHPStan level.

## Vite Build Fails

Run:

```bash
npm install
npm run build
```

Check that new Blade, Livewire, or Filament paths are included in `resources/css/app.css` `@source` directives if Tailwind classes are missing from the build.

## Git Hook Fails

Hooks are expected quality gates:

- `pre-commit`: runs lint-staged.
- `commit-msg`: validates commit message format.
- `pre-push`: runs `composer quality`.

Fix the reported issue and retry the commit or push. Do not bypass hooks unless the team explicitly agrees for an exceptional case.
