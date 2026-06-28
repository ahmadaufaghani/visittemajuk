<?php

it('keeps Tailwind foundation aligned with the static reference tokens and patterns', function (): void {
    $css = file_get_contents(base_path('resources/css/app.css'));

    expect($css)->toContain('--color-brand: #023020')
        ->and($css)->toContain('--color-brand-deep: #011a11')
        ->and($css)->toContain('--color-accent-500: #fd8b00')
        ->and($css)->toContain('--color-surface: #fcf9f9')
        ->and($css)->toContain('--font-display:')
        ->and($css)->toContain('Plus Jakarta Sans')
        ->and($css)->toContain('.app-container')
        ->and($css)->toContain('.section-header')
        ->and($css)->toContain('.btn-accent')
        ->and($css)->toContain('.content-card')
        ->and($css)->toContain('.badge')
        ->and($css)->toContain('.nav-link')
        ->and($css)->toContain('.carousel-control')
        ->and($css)->toContain('.pagination-button')
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
