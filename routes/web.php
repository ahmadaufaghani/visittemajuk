<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

$localePattern = implode(
    '|',
    array_map(
        fn (string $locale): string => preg_quote($locale, '/'),
        config('app.supported_locales', ['id', 'en']),
    ),
);

Route::view('/', 'welcome')->name('home');

Route::prefix('{locale}')
    ->where(['locale' => $localePattern])
    ->middleware(SetLocale::class)
    ->group(function (): void {
        Route::view('/', 'welcome')->name('localized.home');
    });
