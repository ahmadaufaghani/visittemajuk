<x-layouts.app :title="__('Visit Temajuk Application')">
    <section class="section">
        <div class="container">
            <div class="grid gap-8 lg:grid-cols-[1fr_360px] lg:items-start">
                <div class="reveal" x-data="revealMotion()" x-bind:class="{ 'is-visible': visible }">
                    <div class="eyebrow-row">
                        <span aria-hidden="true"></span>
                        <p>{{ __('Laravel CMS application') }}</p>
                    </div>
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
                        <x-public.button href="/admin" variant="orange">{{ __('Open admin') }}</x-public.button>
                        <x-public.button
                            href="https://laravel.com/docs"
                            variant="outline"
                            target="_blank"
                            rel="noreferrer"
                        >
                            {{ __('Laravel docs') }}
                        </x-public.button>
                    </div>
                </div>

                <div class="card reveal" x-data="revealMotion()" x-bind:class="{ 'is-visible': visible }">
                    <x-public.badge>{{ __('Application') }}</x-public.badge>
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
