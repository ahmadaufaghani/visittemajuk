<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locales', function (Blueprint $table): void {
            $table->string('code', 5)->primary();
            $table->string('name');
            $table->string('native_name');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('type')->index();
            $table->string('status')->default('draft')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('category_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('locale_code', 5);
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->foreign('locale_code')->references('code')->on('locales')->cascadeOnDelete();
            $table->unique(['category_id', 'locale_code']);
            $table->unique(['locale_code', 'slug']);
        });

        Schema::create('pages', function (Blueprint $table): void {
            $table->id();
            $table->string('template')->default('default')->index();
            $table->string('status')->default('draft')->index();
            $table->boolean('is_home')->default(false)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('page_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('locale_code', 5);
            $table->string('title');
            $table->string('slug');
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->foreign('locale_code')->references('code')->on('locales')->cascadeOnDelete();
            $table->unique(['page_id', 'locale_code']);
            $table->unique(['locale_code', 'slug']);
        });

        Schema::create('page_sections', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('key')->index();
            $table->string('component')->default('content');
            $table->string('status')->default('draft')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('page_section_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('page_section_id')->constrained()->cascadeOnDelete();
            $table->string('locale_code', 5);
            $table->string('eyebrow')->nullable();
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->longText('body')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('cta_url')->nullable();
            $table->timestamps();

            $table->foreign('locale_code')->references('code')->on('locales')->cascadeOnDelete();
            $table->unique(['page_section_id', 'locale_code']);
        });

        Schema::create('places', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('website_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('place_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('place_id')->constrained()->cascadeOnDelete();
            $table->string('locale_code', 5);
            $table->string('title');
            $table->string('slug');
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('address')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->foreign('locale_code')->references('code')->on('locales')->cascadeOnDelete();
            $table->unique(['place_id', 'locale_code']);
            $table->unique(['locale_code', 'slug']);
        });

        Schema::create('accommodations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->unsignedInteger('price_from')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('booking_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('accommodation_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('accommodation_id')->constrained()->cascadeOnDelete();
            $table->string('locale_code', 5);
            $table->string('title');
            $table->string('slug');
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->json('facilities')->nullable();
            $table->string('address')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->foreign('locale_code')->references('code')->on('locales')->cascadeOnDelete();
            $table->unique(['accommodation_id', 'locale_code'], 'accommodation_locale_unique');
            $table->unique(['locale_code', 'slug']);
        });

        Schema::create('posts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('post_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->string('locale_code', 5);
            $table->string('title');
            $table->string('slug');
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->foreign('locale_code')->references('code')->on('locales')->cascadeOnDelete();
            $table->unique(['post_id', 'locale_code']);
            $table->unique(['locale_code', 'slug']);
        });

        Schema::create('travel_guides', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('layout')->default('content')->index();
            $table->string('status')->default('draft')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('travel_guide_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('travel_guide_id')->constrained()->cascadeOnDelete();
            $table->string('locale_code', 5);
            $table->string('title');
            $table->string('slug');
            $table->text('intro')->nullable();
            $table->longText('body')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->foreign('locale_code')->references('code')->on('locales')->cascadeOnDelete();
            $table->unique(['travel_guide_id', 'locale_code'], 'travel_guide_locale_unique');
            $table->unique(['locale_code', 'slug']);
        });

        Schema::create('travel_route_groups', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('travel_guide_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('draft')->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('travel_route_group_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('travel_route_group_id')->constrained()->cascadeOnDelete();
            $table->string('locale_code', 5);
            $table->string('title');
            $table->text('summary')->nullable();
            $table->timestamps();

            $table->foreign('locale_code')->references('code')->on('locales')->cascadeOnDelete();
            $table->unique(['travel_route_group_id', 'locale_code'], 'travel_route_group_locale_unique');
        });

        Schema::create('travel_routes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('travel_route_group_id')->constrained()->cascadeOnDelete();
            $table->string('transport_mode')->nullable();
            $table->string('departure_time')->nullable();
            $table->decimal('distance_value', 8, 2)->nullable();
            $table->string('distance_unit', 24)->nullable();
            $table->string('status')->default('draft')->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('travel_route_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('travel_route_id')->constrained()->cascadeOnDelete();
            $table->string('locale_code', 5);
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->text('route_summary')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('locale_code')->references('code')->on('locales')->cascadeOnDelete();
            $table->unique(['travel_route_id', 'locale_code']);
        });

        Schema::create('media_assets', function (Blueprint $table): void {
            $table->id();
            $table->string('disk')->default('public');
            $table->string('path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('dominant_color', 32)->nullable();
            $table->string('credit_url')->nullable();
            $table->string('status')->default('published')->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('media_asset_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('media_asset_id')->constrained()->cascadeOnDelete();
            $table->string('locale_code', 5);
            $table->string('alt_text')->nullable();
            $table->text('caption')->nullable();
            $table->string('credit')->nullable();
            $table->timestamps();

            $table->foreign('locale_code')->references('code')->on('locales')->cascadeOnDelete();
            $table->unique(['media_asset_id', 'locale_code']);
        });

        Schema::create('mediaables', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('media_asset_id')->constrained()->cascadeOnDelete();
            $table->morphs('mediaable');
            $table->string('collection')->default('default')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });

        Schema::create('navigation_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('navigation_items')->nullOnDelete();
            $table->string('route_name')->nullable();
            $table->string('url')->nullable();
            $table->string('target')->default('_self');
            $table->string('status')->default('published')->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('navigation_item_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('navigation_item_id')->constrained()->cascadeOnDelete();
            $table->string('locale_code', 5);
            $table->string('label');
            $table->timestamps();

            $table->foreign('locale_code')->references('code')->on('locales')->cascadeOnDelete();
            $table->unique(['navigation_item_id', 'locale_code'], 'navigation_item_locale_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navigation_item_translations');
        Schema::dropIfExists('navigation_items');
        Schema::dropIfExists('mediaables');
        Schema::dropIfExists('media_asset_translations');
        Schema::dropIfExists('media_assets');
        Schema::dropIfExists('travel_route_translations');
        Schema::dropIfExists('travel_routes');
        Schema::dropIfExists('travel_route_group_translations');
        Schema::dropIfExists('travel_route_groups');
        Schema::dropIfExists('travel_guide_translations');
        Schema::dropIfExists('travel_guides');
        Schema::dropIfExists('post_translations');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('accommodation_translations');
        Schema::dropIfExists('accommodations');
        Schema::dropIfExists('place_translations');
        Schema::dropIfExists('places');
        Schema::dropIfExists('page_section_translations');
        Schema::dropIfExists('page_sections');
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('locales');
    }
};
