@props ([
    'eyebrow' => null,
    'title',
    'intro' => null,
    'ctaHref' => null,
    'ctaLabel' => null,
    'light' => false,
])

<div
    {{
        $attributes->class([
            'section-header',
            'section-header-light' => $light,
        ])
    }}
>
    <div>
        @if ($eyebrow)
            <div class="eyebrow-row">
                <span aria-hidden="true"></span>
                <p>{{ $eyebrow }}</p>
            </div>
        @endif

        <h2>{{ $title }}</h2>

        @if ($intro)
            <p class="section-intro">{{ $intro }}</p>
        @endif
    </div>

    @if ($ctaHref && $ctaLabel)
        <x-public.button :href="$ctaHref" :variant="$light ? 'ghost-light' : 'dark'">
            {{ $ctaLabel }} <span aria-hidden="true">-&gt;</span>
        </x-public.button>
    @endif
</div>
