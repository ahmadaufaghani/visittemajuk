@props ([
    'title' => config('app.name', 'Laravel'),
])

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title }} - {{ __('Visit Temajuk') }}</title>
    @vite (['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-surface text-ink min-w-80 font-sans antialiased">
    <x-public.site-header />

    <main id="main-content">{{ $slot }}</main>

    <x-public.site-footer />

    @livewireScriptConfig
</body>
</html>
