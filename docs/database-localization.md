# Database and Localization

The Visit Temajuk database schema supports content management, media, navigation, travel information, and multilingual public content. Authored website content is managed through application and admin workflows rather than versioned directly in the repository.

## Schema Ownership

- Migrations define the database schema.
- `DatabaseSeeder` is limited to approved system data decisions.
- Tests verify that the seed entrypoint stays separate from authored application content.
- Content records are created and maintained through Filament resources and application workflows.

## Main CMS Tables

The primary schema is defined in `database/migrations/2026_06_28_000000_create_visit_temajuk_cms_tables.php`.

Main content tables:

- `pages`: public pages such as home or landing-style pages.
- `page_sections`: reusable page sections such as hero, content, cards, carousel, accordion, and CTA sections.
- `places`: tourism destinations and popular places.
- `accommodations`: places to stay.
- `posts`: news and article-style content.
- `travel_guides`: travel information such as how to get to Temajuk.
- `travel_route_groups` and `travel_routes`: grouped route information for travel guides.
- `categories`: reusable categorization for content.
- `media_assets`: uploaded media metadata.
- `mediaables`: polymorphic media attachments for content models.
- `navigation_items`: multilingual navigation entries.
- `locales`: supported database locales.

Most public content tables include status, ordering, timestamps, and soft deletes. Publishable content also includes publication-related fields where relevant.

## Localization Strategy

Multilingual content is stored in separate translation tables. The project avoids duplicated per-language columns such as:

- `title_id`
- `title_en`
- `description_id`
- `description_en`

Examples of translation tables:

- `page_translations`
- `page_section_translations`
- `place_translations`
- `accommodation_translations`
- `post_translations`
- `travel_guide_translations`
- `media_asset_translations`
- `navigation_item_translations`

Each translation row stores `locale_code` and translated fields such as title, slug, excerpt, body, metadata, caption, or label depending on the content type.

## Why Translation Tables

Translation tables keep the main content models stable as languages and translated fields evolve. They also keep Filament forms cleaner because translations can be managed through relationship repeaters rather than duplicated columns on every content table.

The project targets Indonesian and English:

```env
APP_LOCALE=id
APP_SUPPORTED_LOCALES=id,en
APP_FALLBACK_LOCALE=id
```

## Fallback Behavior

Models use the `HasTranslations` concern to retrieve a translation for the current locale and fall back to the default locale when allowed.

Public localized routes support:

- `/id`
- `/en`

Unsupported locale prefixes return `404`.

## Filament Readiness

Filament resources exist for:

- accommodations,
- categories,
- locales,
- media assets,
- navigation items,
- pages,
- places,
- posts,
- travel guides.

When adding new CRUD fields, keep the migration, model casts/relationships, Filament form, Filament table, and tests aligned.

## Data Rules

- Import authored website content through approved admin and application workflows.
- Keep static design reference content in `design`, not `dev`.
- Store translated fields in translation tables rather than duplicated language-specific columns.
- Keep simple CRUD in standard Laravel MVC unless a concrete implementation need proves otherwise.
- Add tests when changing schema, translation fallback, relationships, or seed behavior.
