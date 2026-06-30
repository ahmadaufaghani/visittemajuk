<article
    {{
        $attributes->class(['accordion-item', 'is-open' => $open])->merge([
            'x-bind:class' => $bindClass(),
            'x-init' => $initExpression(),
        ])
    }}
>
    <button
        class="accordion-trigger"
        type="button"
        x-bind:aria-expanded="isOpen({{ $jsItemId() }}).toString()"
        x-on:click="toggle({{ $jsItemId() }})"
    >
        <span>{{ $title }}</span>
        <span class="accordion-icon" aria-hidden="true"></span>
    </button>
    <div class="accordion-panel">
        <div class="accordion-panel-inner">{{ $slot }}</div>
    </div>
</article>
