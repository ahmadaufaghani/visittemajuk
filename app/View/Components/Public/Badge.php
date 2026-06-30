<?php

namespace App\View\Components\Public;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public string $variantClass;

    public function __construct(public string $variant = 'place')
    {
        $this->variantClass = match ($variant) {
            'stay' => 'category-stay',
            'story', 'news' => 'category-story',
            default => 'category-place',
        };
    }

    public function render(): View
    {
        return view('components.public.badge');
    }
}
