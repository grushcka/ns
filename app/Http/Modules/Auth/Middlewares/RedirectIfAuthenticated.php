<?php

namespace NS\Auth\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Config};

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect(Config::get('user.authenticated_redirect'));
        }

        return $next($request);
    }
}
