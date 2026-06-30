@props ([
    'label' => __('Pagination'),
    'status' => __('Page 1 of 1'),
])

<nav
    {{
        $attributes
            ->class(['pagination'])
            ->merge(['aria-label' => $label])
    }}
>
    <button
        class="pagination-button"
        type="button"
        x-on:click="previous()"
        x-bind:disabled="isFirstPage"
        aria-label="{{ __('Previous page') }}"
    >
        <span aria-hidden="true">&lt;</span>
    </button>
    <span class="pagination-status" x-text="status">{{ $status }}</span>
    <button
        class="pagination-button"
        type="button"
        x-on:click="next()"
        x-bind:disabled="isLastPage"
        aria-label="{{ __('Next page') }}"
    >
        <span aria-hidden="true">&gt;</span>
    </button>
</nav>
