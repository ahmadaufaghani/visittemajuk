<x-layouts.app :title="__('Visit Temajuk Application')">
    <section class="section">
        <div class="app-container">
            <div class="grid gap-8 lg:grid-cols-[1fr_360px] lg:items-start">
                <div class="reveal-motion">
                    <p class="eyebrow">{{ __('Laravel CMS application') }}</p>
                    <h1 class="page-title mt-5 max-w-3xl text-balance">
                        {{ __('Application workspace for the development team.') }}
                    </h1>
                    <p class="section-description mt-6">
                        {{
                            __(
                                'The repository provides Laravel structure, CMS schema, admin resources, and reusable frontend styling primitives for team development.',
                            )
                        }}
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a class="btn btn-accent" href="/admin">{{ __('Open admin') }}</a>
                        <a class="btn btn-secondary" href="https://laravel.com/docs" target="_blank" rel="noreferrer">
                            {{ __('Laravel docs') }}
                        </a>
                    </div>
                </div>

                <div class="card reveal-motion">
                    <span class="badge badge-place">{{ __('Application') }}</span>
                    <h2 class="font-display text-ink mt-4 text-xl font-extrabold">
                        {{ __('Available project areas') }}
                    </h2>
                    <ul class="text-muted mt-4 space-y-3 text-sm leading-6">
                        <li>{{ __('Laravel MVC structure') }}</li>
                        <li>{{ __('Filament admin resources') }}</li>
                        <li>{{ __('Database schema') }}</li>
                        <li>{{ __('Quality tools and Git hooks') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
