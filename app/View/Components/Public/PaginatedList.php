<?php

namespace App\View\Components\Public;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Js;
use Illuminate\View\Component;

class PaginatedList extends Component
{
    public string $label;

    public function __construct(
        public int|string|null $pageSize = 6,
        public int|string|null $pageSizeDesktop = null,
        public int|string|null $pageSizeTablet = null,
        public int|string|null $pageSizeMobile = null,
        ?string $label = null,
        public string $gridClass = 'card-grid',
    ) {
        $this->label = $label ?? __('Pagination');
    }

    public function paginationConfig(): array
    {
        return array_filter(
            [
                'pageSize' => $this->pageSize,
                'pageSizeDesktop' => $this->pageSizeDesktop,
                'pageSizeTablet' => $this->pageSizeTablet,
                'pageSizeMobile' => $this->pageSizeMobile,
            ],
            fn ($value): bool => filled($value),
        );
    }

    public function xData(): string
    {
        return 'publicPagination('.Js::from($this->paginationConfig()).')';
    }

    public function render(): View
    {
        return view('components.public.paginated-list');
    }
}
