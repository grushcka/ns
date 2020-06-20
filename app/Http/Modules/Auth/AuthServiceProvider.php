<?php

namespace NS\Auth;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use NS\Auth\Guards\AuthGuard;
use NS\Auth\Middlewares\RedirectIfAuthenticated;

class AuthServiceProvider extends ServiceProvider
{

    private array $middlewares = [
        'guest' => RedirectIfAuthenticated::class,
    ];
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected array $policies = [
        // 'NS\Model' => 'NS\Policies\ModelPolicy',
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
        $this->loadViewsFrom(__DIR__.'/Views/', 'auth');
        $this->registerEventListeners();
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
            $this->app->bind($abstract, $class);
        }
    }

    private function registerEventListeners(): void
    {
        Event::listen('auth.*', static function ($eventName, array $data) {
            dd($eventName, $data);
        });
    }
}
