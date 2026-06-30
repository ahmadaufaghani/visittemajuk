<div
    {{
        $attributes->class(['paginated-list'])->merge([
            'x-data' => $xData(),
        ])
    }}
>
    <div class="{{ $gridClass }}" x-ref="items">{{ $slot }}</div>

    <x-public.pagination :label="$label" />
</div>
