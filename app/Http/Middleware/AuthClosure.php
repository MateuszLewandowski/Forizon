<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Models\User;
use Closure;

class AuthClosure
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user;
        App::bind(User::class, function() use ($user) {
            return $user;
        });

        return $next($request);
    }
}
