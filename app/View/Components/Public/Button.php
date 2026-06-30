<?php

namespace App\View\Components\Public;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public string $variantClass;

    public function __construct(
        public ?string $href = null,
        public string $type = 'button',
        public string $variant = 'dark',
    ) {
        $this->variantClass = match ($variant) {
            'accent', 'orange' => 'button-orange',
            'ghost', 'ghost-light' => 'button-ghost-light',
            'secondary', 'outline' => 'button-outline',
            'primary', 'dark' => 'button-dark',
            default => "button-{$variant}",
        };
    }

    public function render(): View
    {
        return view('components.public.button');
    }
}
