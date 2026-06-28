<?php

use App\Models\Category;
use App\Models\Locale;
use App\Models\Place;

it('stores multilingual content in translation tables and falls back to Indonesian', function (): void {
    Locale::query()->create([
        'code' => 'id',
        'name' => 'Indonesian',
        'native_name' => 'Indonesia',
        'is_default' => true,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    Locale::query()->create([
        'code' => 'en',
        'name' => 'English',
        'native_name' => 'English',
        'is_default' => false,
        'is_active' => true,
        'sort_order' => 2,
    ]);

    $category = Category::query()->create([
        'type' => 'place',
        'status' => 'published',
        'sort_order' => 1,
    ]);

    $category->translations()->create([
        'locale_code' => 'id',
        'name' => 'Destination',
        'slug' => 'destination',
    ]);

    $place = Place::query()->create([
        'category_id' => $category->id,
        'status' => 'published',
        'published_at' => now(),
        'is_featured' => true,
        'sort_order' => 1,
    ]);

    $place->translations()->create([
        'locale_code' => 'id',
        'title' => 'Sample Place',
        'slug' => 'sample-place',
        'excerpt' => 'Sample excerpt for translation testing.',
        'body' => 'Sample body for translation testing.',
        'meta_title' => 'Sample Place',
        'meta_description' => 'Sample metadata for translation testing.',
    ]);

    expect($place->translation('id')->title)->toBe('Sample Place')
        ->and($place->translation('en')->title)->toBe('Sample Place')
        ->and($place->translation('en')->locale_code)->toBe('id');

    $found = Place::query()
        ->whereHas('translations', fn ($query) => $query
            ->where('locale_code', 'id')
            ->where('slug', 'sample-place'))
        ->first();

    expect($found)->not->toBeNull()
        ->and($found->is($place))->toBeTrue();
});
