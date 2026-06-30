<?php

namespace App\View\Components\Public;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Js;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class AccordionItem extends Component
{
    public string $itemId;

    public function __construct(public string $title, public bool $open = false, ?string $id = null)
    {
        $this->itemId = $id ?? Str::slug($title);
    }

    public function bindClass(): string
    {
        return "{ 'is-open': isOpen(".$this->jsItemId().') }';
    }

    public function initExpression(): string|false
    {
        return $this->open ? 'setOpen('.$this->jsItemId().')' : false;
    }

    public function jsItemId(): string
    {
        return (string) Js::from($this->itemId);
    }

    public function render(): View
    {
        return view('components.public.accordion-item');
    }
}
