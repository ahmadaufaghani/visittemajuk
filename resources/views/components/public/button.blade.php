@if ($href)
    <a
        {{
            $attributes->class(['button', $variantClass])->merge([
                'href' => $href,
            ])
        }}
    >
        {{ $slot }}
    </a>
@else
    <button
        {{
            $attributes->class(['button', $variantClass])->merge([
                'type' => $type,
            ])
        }}
    >
        {{ $slot }}
    </button>
@endif
