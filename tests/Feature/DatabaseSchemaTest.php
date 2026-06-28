<?php

use Illuminate\Support\Facades\Schema;

it('creates CMS tables with separate translation tables instead of duplicated language columns', function (): void {
    foreach ([
        'locales',
        'pages',
        'page_translations',
        'page_sections',
        'page_section_translations',
        'categories',
        'category_translations',
        'places',
        'place_translations',
        'accommodations',
        'accommodation_translations',
        'posts',
        'post_translations',
        'travel_guides',
        'travel_guide_translations',
        'travel_route_groups',
        'travel_route_group_translations',
        'travel_routes',
        'travel_route_translations',
        'media_assets',
        'media_asset_translations',
        'mediaables',
        'navigation_items',
        'navigation_item_translations',
    ] as $table) {
        expect(Schema::hasTable($table))->toBeTrue("Expected table [{$table}] to exist.");
    }

    foreach (['places', 'accommodations', 'posts', 'pages', 'categories'] as $table) {
        expect(Schema::hasColumn($table, 'title_id'))->toBeFalse()
            ->and(Schema::hasColumn($table, 'title_en'))->toBeFalse()
            ->and(Schema::hasColumn($table, 'description_id'))->toBeFalse()
            ->and(Schema::hasColumn($table, 'description_en'))->toBeFalse();
    }

    expect(Schema::hasColumns('place_translations', [
        'place_id',
        'locale_code',
        'title',
        'slug',
        'excerpt',
        'body',
        'meta_title',
        'meta_description',
    ]))->toBeTrue();
});
