<?php

namespace App\View\Components\Public;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SiteHeader extends Component
{
    public string $brand;

    public array $navItems;

    public array $supportedLocales;

    public string $currentLocale;

    private string $currentPath;

    public function __construct(?string $brand = null, ?array $navItems = null)
    {
        $this->brand = $brand ?? __('Visit Temajuk');
        $this->supportedLocales = array_values(array_filter((array) config('app.supported_locales', ['id', 'en'])));
        $this->currentLocale = app()->getLocale();
        $this->currentPath = trim(request()->path(), '/');
        $this->navItems = $navItems ?? $this->defaultNavItems();
    }

    public function isActive(array $item): bool
    {
        $pattern = $item['pattern'] ?? null;

        if ($pattern === '/') {
            return request()->is('/') || request()->is('id') || request()->is('en');
        }

        return $pattern
            ? request()->is($pattern) || request()->is("id/{$pattern}") || request()->is("en/{$pattern}")
            : false;
    }

    public function localizedUrl(string $locale): string
    {
        $segments = $this->currentPath === '' ? [] : explode('/', $this->currentPath);

        if ($segments && in_array($segments[0], $this->supportedLocales, true)) {
            $segments[0] = $locale;
        } else {
            array_unshift($segments, $locale);
        }

        return url(implode('/', $segments));
    }

    public function render(): View
    {
        return view('components.public.site-header');
    }

    private function defaultNavItems(): array
    {
        return [
            ['label' => __('Home'), 'href' => route('home'), 'pattern' => '/'],
            ['label' => __('Popular Places'), 'href' => url('/popular-places'), 'pattern' => 'popular-places*'],
            ['label' => __('Places To Stay'), 'href' => url('/places-to-stay'), 'pattern' => 'places-to-stay*'],
            ['label' => __('News of Temajuk'), 'href' => url('/news'), 'pattern' => 'news*'],
            ['label' => __('How To Get There'), 'href' => url('/how-to-get-there'), 'pattern' => 'how-to-get-there*'],
        ];
    }
}
