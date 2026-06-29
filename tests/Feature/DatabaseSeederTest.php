<?php

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\DB;

it('keeps application content out of the default seeder', function (): void {
    $this->seed(DatabaseSeeder::class);

    foreach (['users', 'locales', 'categories', 'places', 'accommodations', 'posts', 'travel_guides'] as $table) {
        expect(DB::table($table)->count())->toBe(0, "Expected [{$table}] to stay unchanged by DatabaseSeeder.");
    }
});
