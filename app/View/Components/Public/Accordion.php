<?php

namespace App\View\Components\Public;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Js;
use Illuminate\View\Component;

class Accordion extends Component
{
    public string $label;

    public function __construct(?string $label = null, public ?string $defaultOpen = null)
    {
        $this->label = $label ?? __('Accordion content');
    }

    public function xData(): string
    {
        return 'publicAccordion('.Js::from(['defaultOpen' => $this->defaultOpen]).')';
    }

    public function render(): View
    {
        return view('components.public.accordion');
    }
}
