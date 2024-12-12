<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->header('lang', 'en');

        if (in_array($locale, ['en', 'uz'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
