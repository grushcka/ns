<?php

namespace NS\User\Middlewares;

use Closure;
use Illuminate\Http\Request;

/**
 * Class CurrentUserProfile
 * If we get empty user param - use current user
 * @package NS\User\Middlewares
 */
class CurrentUserProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->route('user')) {
            optional($request->route())->setParameter('user', auth()->user());
        }

        return $next($request);
    }
}
