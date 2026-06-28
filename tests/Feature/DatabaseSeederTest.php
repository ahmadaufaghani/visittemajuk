<?php

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\DB;

it('does not seed application data in the boilerplate', function (): void {
    $this->seed(DatabaseSeeder::class);

    foreach (['users', 'locales', 'categories', 'places', 'accommodations', 'posts', 'travel_guides'] as $table) {
        expect(DB::table($table)->count())->toBe(0, "Expected [{$table}] to remain empty.");
    }
});
