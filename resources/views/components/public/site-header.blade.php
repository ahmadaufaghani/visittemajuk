<header class="site-header" x-data="mobileMenu()" x-on:keydown.escape.window="close()">
    <div class="header-inner container">
        <a class="brand" href="{{ route('home') }}" aria-label="{{ __('Visit Temajuk Home') }}">
            <span aria-hidden="true"></span>
            <strong>{{ $brand }}</strong>
        </a>

        <nav class="desktop-nav" aria-label="{{ __('Primary navigation') }}">
            @foreach ($navItems as $item)
                <a class="{{ $isActive($item) ? 'active' : '' }}" href="{{ $item['href'] }}"> {{ $item['label'] }} </a>
            @endforeach
        </nav>

        <div class="header-actions">
            <a class="admin-button" href="{{ url('/admin') }}">{{ __('Admin') }}</a>
            <div class="language-toggle" aria-label="{{ __('Language switch') }}">
                @foreach ($supportedLocales as $locale)
                    <a class="{{ $currentLocale === $locale ? 'active' : '' }}" href="{{ $localizedUrl($locale) }}">
                        {{ strtoupper($locale) }}
                    </a>
                @endforeach
            </div>
            <button
                class="menu-toggle"
                type="button"
                x-bind:class="{ 'is-open': open }"
                x-bind:aria-expanded="open.toString()"
                aria-controls="mobile-menu"
                x-bind:aria-label="open ? @js(__('Close menu')) : @js(__('Open menu'))"
                x-on:click="toggle()"
            >
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

    <nav
        id="mobile-menu"
        class="mobile-nav"
        x-bind:class="{ 'is-open': open }"
        aria-label="{{ __('Mobile navigation') }}"
        x-on:click="closeFromLink($event)"
        x-cloak
    >
        @foreach ($navItems as $item)
            <a class="{{ $isActive($item) ? 'active' : '' }}" href="{{ $item['href'] }}">{{ $item['label'] }}</a>
        @endforeach
        <div class="mobile-nav-actions">
            <a class="admin-button" href="{{ url('/admin') }}">{{ __('Admin') }}</a>
            <div class="language-toggle" aria-label="{{ __('Language switch') }}">
                @foreach ($supportedLocales as $locale)
                    <a class="{{ $currentLocale === $locale ? 'active' : '' }}" href="{{ $localizedUrl($locale) }}">
                        {{ strtoupper($locale) }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>
</header>
