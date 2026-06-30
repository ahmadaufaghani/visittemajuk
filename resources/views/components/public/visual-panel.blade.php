@props ([
    'label' => __('Visit Temajuk visual'),
    'tone' => 'forest',
    'ratio' => 'card',
])

<div
    {{
        $attributes->class([
            'visual-panel',
            "tone-{$tone}",
            "ratio-{$ratio}",
        ])
    }}
    role="img"
    aria-label="{{ $label }}"
>
    <div class="visual-grid" aria-hidden="true"></div>
    <div class="visual-line" aria-hidden="true"></div>
    {{ $slot }}
</div>
