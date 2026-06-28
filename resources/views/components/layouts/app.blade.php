@props ([
    'title' => config('app.name', 'Laravel'),
])

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title }} - {{ config('app.name') }}</title>
    @vite (['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-surface text-ink min-w-80 font-sans antialiased">
    <header class="site-header">
        <div class="app-container header-bar">
            <a href="{{ route('home') }}" class="brand-mark"> {{ config('app.name') }} </a>
            <nav class="site-nav" aria-label="Primary navigation">
                <a class="nav-link nav-link-active" href="{{ route('home') }}"> {{ __('Home') }} </a>
                <a class="nav-link" href="/admin"> {{ __('Admin') }} </a>
            </nav>
        </div>
    </header>

    <main>{{ $slot }}</main>

    @livewireScripts
</body>
</html>
