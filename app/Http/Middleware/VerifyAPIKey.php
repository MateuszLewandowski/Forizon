<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

class VerifyAPIKey
{
    /**
     * @var array $excluded
     */
    private array $excluded = [
        '/api/documentation',
        '/docs/api-docs.json',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        if ($request->header('api_key', false) !== config('api.key') and !in_array($request->getRequestUri(), $this->excluded)) {
            throw new HttpException(Response::HTTP_FORBIDDEN, '');
        }

        return $next($request);
    }
}
