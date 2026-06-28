<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = (string) $request->route('locale');
        $supportedLocales = config('app.supported_locales', [config('app.locale', 'id')]);

        abort_unless(in_array($locale, $supportedLocales, true), 404);

        app()->setLocale($locale);

        return $next($request);
    }
}
