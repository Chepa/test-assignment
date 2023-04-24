<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Language
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->segment(1), \App\Enums\Language::toArray())) {
            app()->setLocale($request->segment(1));
        }

        return $next($request);
    }
}
