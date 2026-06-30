<div
    {{
        $attributes->class(['accordion-list'])->merge([
            'aria-label' => $label,
            'x-data' => $xData(),
        ])
    }}
>
    {{ $slot }}
</div>
