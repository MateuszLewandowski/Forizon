<?php

namespace App\Http\Middleware;

use App\Services\Auth\JSONWebToken as JWTService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyJWT
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
        [$status, $user] = (new JWTService)->getUserWithToken($request->header('JWT', ''));
        if ($status !== Response::HTTP_OK) {
            throw new HttpException(Response::HTTP_FORBIDDEN, __('auth.not_authorized'));
        }

        return $next($request);
    }
}
