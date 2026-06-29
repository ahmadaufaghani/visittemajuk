<?php

use App\Models\MediaAsset;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\TravelGuide;
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

it('allows visual media to be attached to pages, page sections, and travel guides', function (): void {
    $media = MediaAsset::query()->create([
        'disk' => 'public',
        'path' => 'content/example.jpg',
        'status' => 'published',
        'sort_order' => 1,
    ]);

    $page = Page::query()->create([
        'template' => 'home',
        'status' => 'draft',
        'is_home' => true,
        'sort_order' => 1,
    ]);

    $section = PageSection::query()->create([
        'page_id' => $page->id,
        'key' => 'hero',
        'component' => 'hero',
        'status' => 'draft',
        'sort_order' => 1,
    ]);

    $travelGuide = TravelGuide::query()->create([
        'key' => 'how-to-get-there',
        'layout' => 'accordion',
        'status' => 'draft',
        'sort_order' => 1,
    ]);

    $page->mediaAssets()->attach($media->id, [
        'collection' => 'hero',
        'is_featured' => true,
        'sort_order' => 1,
    ]);

    $section->mediaAssets()->attach($media->id, [
        'collection' => 'background',
        'is_featured' => true,
        'sort_order' => 1,
    ]);

    $travelGuide->mediaAssets()->attach($media->id, [
        'collection' => 'map',
        'is_featured' => false,
        'sort_order' => 1,
    ]);

    expect($page->mediaAssets()->wherePivot('collection', 'hero')->exists())->toBeTrue()
        ->and($section->mediaAssets()->wherePivot('collection', 'background')->exists())->toBeTrue()
        ->and($travelGuide->mediaAssets()->wherePivot('collection', 'map')->exists())->toBeTrue();
});
