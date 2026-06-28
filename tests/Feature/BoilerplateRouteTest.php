<?php

beforeEach(function (): void {
    $this->withoutVite();
});

it('renders the neutral boilerplate home page', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSee('Boilerplate', false)
        ->assertSee('schema', false);
});

it('renders supported locale prefixes without database seed data', function (): void {
    foreach (['id', 'en'] as $locale) {
        $this->get("/{$locale}")
            ->assertOk()
            ->assertSee('Filament', false);
    }
});

it('rejects unsupported locale prefixes', function (): void {
    $this->get('/fr')->assertNotFound();
});
