<?php

namespace App\View\Components\Public;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CarouselControl extends Component
{
    public bool $isPrevious;

    public string $label;

    public function __construct(public string $direction = 'next', ?string $label = null)
    {
        $this->isPrevious = $direction === 'previous';
        $this->label = $label ?? ($this->isPrevious ? __('Previous slide') : __('Next slide'));
    }

    public function clickAction(): string
    {
        return $this->isPrevious ? 'scroll(-1)' : 'scroll(1)';
    }

    public function disabledBinding(): string
    {
        return $this->isPrevious ? 'atStart' : 'atEnd';
    }

    public function glyph(): string
    {
        return $this->isPrevious ? '<' : '>';
    }

    public function render(): View
    {
        return view('components.public.carousel-control');
    }
}
