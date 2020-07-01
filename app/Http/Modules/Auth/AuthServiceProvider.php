<?php

namespace NS\Auth;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\{Event, Route};
use NS\Auth\Middlewares\RedirectIfAuthenticated;
use NS\Auth\Models\AuthLog;

class AuthServiceProvider extends ServiceProvider
{

    private array $middlewares = [
        'guest' => RedirectIfAuthenticated::class,
    ];


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->registerRoutes();
        $this->registerMiddlewares();
        $this->mergeConfigFrom(__DIR__.'/Config/auth.php', 'auth');
    }

    /**
     * @return void
     */
    private function registerRoutes(): void
    {
        Route::prefix('auth')
            ->group(static function () {
                Route::middleware('web')
                    ->name('auth')
                    ->namespace('NS\Auth\Controllers')
                    ->group(__DIR__.'/Routes/auth_routes.php');
            });
    }

    private function registerMiddlewares(): void
    {
        foreach ($this->middlewares as $abstract => $class) {
            $this->app->singleton($abstract, $class);
        }
    }
}
