<?php

it('keeps Tailwind foundation aligned with the static reference tokens and patterns', function (): void {
    $css = file_get_contents(base_path('resources/css/app.css'));

    expect($css)->toContain('--brand: #023020')
        ->and($css)->toContain('--brand-deep: #011a11')
        ->and($css)->toContain('--accent-orange: #fd8b00')
        ->and($css)->toContain('--surface: #fcf9f9')
        ->and($css)->toContain('--color-brand: var(--brand)')
        ->and($css)->toContain('--color-accent-orange: var(--accent-orange)')
        ->and($css)->toContain('--font-display:')
        ->and($css)->toContain('Plus Jakarta Sans')
        ->and($css)->toContain('.container')
        ->and($css)->toContain('.header-inner')
        ->and($css)->toContain('.brand')
        ->and($css)->toContain('.section-header')
        ->and($css)->toContain('.button-orange')
        ->and($css)->toContain('.content-card')
        ->and($css)->toContain('.category-badge')
        ->and($css)->toContain('.desktop-nav a')
        ->and($css)->toContain('.carousel-control')
        ->and($css)->toContain('.pagination button')
        ->and($css)->toContain('.accordion-trigger')
        ->and($css)->toContain('@media (prefers-reduced-motion: reduce)');
});

it('uses the Tailwind 4 Vite integration and frontend formatting plugins', function (): void {
    $package = json_decode(file_get_contents(base_path('package.json')), true, flags: JSON_THROW_ON_ERROR);
    $viteConfig = file_get_contents(base_path('vite.config.js'));
    $prettierConfig = file_get_contents(base_path('prettier.config.js'));

    expect($package['devDependencies'])->toHaveKey('tailwindcss')
        ->and($package['devDependencies'])->toHaveKey('@tailwindcss/vite')
        ->and($package['devDependencies'])->toHaveKey('prettier-plugin-tailwindcss')
        ->and($viteConfig)->toContain("import tailwindcss from '@tailwindcss/vite';")
        ->and($viteConfig)->toContain('tailwindcss()')
        ->and($prettierConfig)->toContain('prettier-plugin-tailwindcss');
});
