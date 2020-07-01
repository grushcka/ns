<?php

namespace NS\User\Middlewares;

use Closure;
use Illuminate\Http\Request;

class IsSuspended
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
        if (auth()->check() && auth()->user()->is_suspend) {
            auth()->logout();

            return redirect()->route('auth.login')
                ->withMessage(__('user.suspend'));
        }

        return $next($request);
    }
}
