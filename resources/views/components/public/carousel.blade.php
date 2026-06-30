@props ([
    'label' => __('Content carousel'),
    'status' => '1 / 1',
])

<div
    {{
        $attributes
            ->class(['carousel'])
            ->merge(['x-data' => 'publicCarousel()'])
    }}
>
    <x-public.carousel-control direction="previous" />

    <div class="carousel-viewport">
        <div
            class="carousel-track"
            x-ref="track"
            x-on:scroll.passive="scheduleUpdate()"
            tabindex="0"
            aria-label="{{ $label }}"
        >
            {{ $slot }}
        </div>
    </div>

    <x-public.carousel-control direction="next" />

    <div class="carousel-status" aria-live="polite" x-text="status">{{ $status }}</div>
</div>
