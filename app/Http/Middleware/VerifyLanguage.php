<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class VerifyLanguage
{
    /**
     * Available languages
     *
     * @var array
     */
    private array $available = ['pl', 'en'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->header('lang', 'en');
        App::setLocale(! in_array($lang, $this->available) ? $lang : 'en');

        return $next($request);
    }
}
