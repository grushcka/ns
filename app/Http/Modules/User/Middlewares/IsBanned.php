<?php

namespace NS\User\Middlewares;

use Closure;
use Illuminate\Http\Request;

class IsBanned
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
        if (auth()->check() && auth()->user()->is_banned) {
            auth()->logout();
            return redirect()->route('auth.login')
                ->withMessage(__('user.banned'));
        }

        return $next($request);
    }
}
