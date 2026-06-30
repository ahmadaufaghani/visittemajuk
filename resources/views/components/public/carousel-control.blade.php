<button
    {{
        $attributes
            ->class(['carousel-control', $isPrevious ? 'carousel-control-prev' : 'carousel-control-next'])
            ->merge([
                'type' => 'button',
                'x-on:click' => $clickAction(),
                'x-bind:disabled' => $disabledBinding(),
                'aria-label' => $label,
            ])
    }}
>
    <span aria-hidden="true">{{ $glyph() }}</span>
</button>
