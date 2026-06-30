<?php

use Illuminate\Support\Facades\Blade;

it('provides shared public layout components for phase one pages', function (): void {
    $componentPaths = [
        'resources/views/components/public/accordion.blade.php',
        'resources/views/components/public/accordion-item.blade.php',
        'resources/views/components/public/badge.blade.php',
        'resources/views/components/public/button.blade.php',
        'resources/views/components/public/carousel.blade.php',
        'resources/views/components/public/carousel-control.blade.php',
        'resources/views/components/public/content-card.blade.php',
        'resources/views/components/public/paginated-list.blade.php',
        'resources/views/components/public/pagination.blade.php',
        'resources/views/components/public/section-header.blade.php',
        'resources/views/components/public/site-footer.blade.php',
        'resources/views/components/public/site-header.blade.php',
        'resources/views/components/public/visual-panel.blade.php',
    ];

    foreach ($componentPaths as $path) {
        expect(base_path($path))->toBeFile();
    }
});

it('places public component presentation logic in class-based Laravel components', function (): void {
    $componentClassPaths = [
        'app/View/Components/Public/Accordion.php',
        'app/View/Components/Public/AccordionItem.php',
        'app/View/Components/Public/Badge.php',
        'app/View/Components/Public/Button.php',
        'app/View/Components/Public/CarouselControl.php',
        'app/View/Components/Public/PaginatedList.php',
        'app/View/Components/Public/SiteHeader.php',
    ];

    foreach ($componentClassPaths as $path) {
        expect(base_path($path))->toBeFile();
    }
});

it('renders class-backed public components with their expected public classes and bindings', function (): void {
    $button = Blade::render('<x-public.button href="/admin" variant="orange">Open</x-public.button>');
    $badge = Blade::render('<x-public.badge variant="news">News</x-public.badge>');
    $accordion = Blade::render(
        '<x-public.accordion default-open="intro"><x-public.accordion-item title="Intro" :open="true">Body</x-public.accordion-item></x-public.accordion>',
    );
    $carouselControl = Blade::render('<x-public.carousel-control direction="previous" />');
    $paginatedList = Blade::render('<x-public.paginated-list page-size="3"><div>Item</div></x-public.paginated-list>');

    expect($button)->toContain('button-orange')
        ->and($button)->toContain('href="/admin"')
        ->and($badge)->toContain('category-story')
        ->and($accordion)->toContain('publicAccordion(')
        ->and($accordion)->toContain('setOpen(')
        ->and($carouselControl)->toContain('carousel-control-prev')
        ->and($carouselControl)->toContain('scroll(-1)')
        ->and($paginatedList)->toContain('publicPagination(')
        ->and($paginatedList)->toContain('card-grid');
});

it('keeps public component presentation templates free of inline PHP blocks and framework FQCN logic', function (): void {
    $componentPaths = array_merge(
        glob(resource_path('views/components/*.blade.php')) ?: [],
        glob(resource_path('views/components/*/*.blade.php')) ?: [],
    );

    foreach ($componentPaths as $path) {
        $contents = file_get_contents($path);

        expect($contents)
            ->not->toContain('@php')
            ->not->toContain('Illuminate\\Support\\');
    }
});

it('uses shared header and footer from the application layout', function (): void {
    $layout = file_get_contents(resource_path('views/components/layouts/app.blade.php'));

    expect($layout)->toContain('<x-public.site-header')
        ->and($layout)->toContain('<x-public.site-footer')
        ->and($layout)->toContain('@vite')
        ->and($layout)->toContain('@livewireStyles')
        ->and($layout)->toContain('@livewireScriptConfig')
        ->and($layout)->not->toContain('@livewireScripts');
});

it('keeps shared public layout markup aligned with the static reference contract', function (): void {
    $header = file_get_contents(resource_path('views/components/public/site-header.blade.php'));
    $footer = file_get_contents(resource_path('views/components/public/site-footer.blade.php'));
    $button = file_get_contents(resource_path('views/components/public/button.blade.php'));
    $buttonClass = file_get_contents(app_path('View/Components/Public/Button.php'));
    $badge = file_get_contents(resource_path('views/components/public/badge.blade.php'));
    $badgeClass = file_get_contents(app_path('View/Components/Public/Badge.php'));
    $card = file_get_contents(resource_path('views/components/public/content-card.blade.php'));
    $sectionHeader = file_get_contents(resource_path('views/components/public/section-header.blade.php'));

    expect($header)->toContain('x-data="mobileMenu()"')
        ->and($header)->toContain('header-inner')
        ->and($header)->toContain('container')
        ->and($header)->toContain('class="brand"')
        ->and($header)->toContain('class="desktop-nav"')
        ->and($header)->not->toContain('app-container')
        ->and($header)->not->toContain('brand-mark')
        ->and($footer)->toContain('footer-grid')
        ->and($footer)->toContain('container')
        ->and($footer)->toContain('brand footer-brand')
        ->and($footer)->toContain('<h3>')
        ->and($button)->toContain('button')
        ->and($buttonClass)->toContain('button-orange')
        ->and($buttonClass)->toContain('button-ghost-light')
        ->and($badge)->toContain('category-badge')
        ->and($badgeClass)->toContain('category-place')
        ->and($card)->toContain('card-body')
        ->and($card)->not->toContain('content-card-body')
        ->and($sectionHeader)->toContain('eyebrow-row')
        ->and($sectionHeader)->not->toContain('class="eyebrow"');
});

it('registers reusable public interactions as Alpine components for phase one UI primitives', function (): void {
    $javascript = file_get_contents(resource_path('js/app.js'));
    $css = file_get_contents(resource_path('css/app.css'));

    expect($javascript)->toContain('import { Livewire, Alpine }')
        ->and($javascript)->toContain('Livewire.start()')
        ->and($javascript)->not->toContain("from 'alpinejs'")
        ->and($javascript)->toContain("Alpine.data('mobileMenu'")
        ->and($javascript)->toContain("Alpine.data('publicCarousel'")
        ->and($javascript)->toContain("Alpine.data('publicPagination'")
        ->and($javascript)->toContain("Alpine.data('publicAccordion'")
        ->and($javascript)->not->toContain('data-mobile-menu')
        ->and($javascript)->not->toContain("document.addEventListener('DOMContentLoaded'")
        ->and($javascript)->toContain('prefers-reduced-motion: reduce')
        ->and($css)->toContain('.container')
        ->and($css)->toContain('.header-inner')
        ->and($css)->toContain('.brand')
        ->and($css)->toContain('.mobile-nav')
        ->and($css)->toContain('.header-actions')
        ->and($css)->toContain('.site-footer')
        ->and($css)->toContain('.footer-grid')
        ->and($css)->toContain('.visual-panel')
        ->and($css)->toContain('.accordion-panel')
        ->and($css)->toContain('@media (prefers-reduced-motion: reduce)');
});
