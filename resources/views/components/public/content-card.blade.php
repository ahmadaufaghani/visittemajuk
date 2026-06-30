@props ([
    'href' => '#',
    'title',
    'excerpt' => null,
    'badge' => null,
    'badgeVariant' => 'place',
    'tone' => 'forest',
    'action' => __('Explore'),
])

<a
    {{
        $attributes
            ->class(['content-card'])
            ->merge(['href' => $href])
    }}
>
    <div class="card-media-wrap">
        <x-public.visual-panel :label="$title" :tone="$tone" ratio="card" />
    </div>
    <div class="card-body">
        @if ($badge)
            <x-public.badge :variant="$badgeVariant">{{ $badge }}</x-public.badge>
        @endif

        <h3>{{ $title }}</h3>

        @if ($excerpt)
            <p>{{ $excerpt }}</p>
        @endif

        <span class="card-action"> {{ $action }} <span aria-hidden="true">-&gt;</span> </span>
    </div>
</a>
