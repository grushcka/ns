<?php

namespace NS\User;

use Illuminate\Support\{Facades\Gate, Facades\Route, ServiceProvider};
use NS\User\Middlewares\CurrentUserProfile;
use NS\User\Models\User;
use Illuminate\Auth\Access\Response;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *!!
     * @return void
     */
    public function boot(): void
    {
        $this->addProfileRoutes();
        $this->registerPolicies();

        $this->loadMigrationsFrom(__DIR__.'/DB/migrations');
        $this->loadViewsFrom(__DIR__.'/Views', 'user');
    }

    /**
     * Profile Control routes
     * @return void
     */
    private function addProfileRoutes(): void
    {
        Route::prefix('user')
            ->group(static function () {
                Route::middleware([
                    'web',
                    'auth',
                    CurrentUserProfile::class,
                ])
                    ->where(['user' => '\d+?'])
                    ->name('profile')
                    ->namespace('NS\User\Controllers')
                    ->group(__DIR__.'/Routes/profile_routes.php');
            });
    }

    private function registerPolicies(): void
    {
        Gate::define('change-profile', static function (User $user, User $profile) {
            return $user->id === $profile->id
                ? Response::allow()
                : Response::deny(trans('You do not have permission.'));
        });
    }

}
