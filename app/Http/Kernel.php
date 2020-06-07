<?php

namespace NS\Http;

use Fruitcake\Cors\HandleCors;
use Illuminate\Auth\Middleware\{
    AuthenticateWithBasicAuth,
    Authorize,
    EnsureEmailIsVerified,
    RequirePassword
};
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\{
    Kernel as HttpKernel,
    Middleware\ConvertEmptyStringsToNull,
    Middleware\ValidatePostSize
};
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\{
    SubstituteBindings,
    ThrottleRequests,
    ValidateSignature
};
use Illuminate\Session\{
    Middleware\AuthenticateSession,
    Middleware\StartSession
};
use Illuminate\View\Middleware\ShareErrorsFromSession;
use NS\Http\Middleware\{
    Authenticate,
    CheckForMaintenanceMode,
    EncryptCookies,
    RedirectIfAuthenticated,
    TrimStrings,
    TrustProxies,
    VerifyCsrfToken
};

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected array $middleware = [
        // \NS\Http\Middleware\TrustHosts::class,
        TrustProxies::class,
        HandleCors::class,
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected array $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected array $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'password.confirm' => RequirePassword::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EnsureEmailIsVerified::class,
    ];
}
