<?php

namespace NS\User;

use Illuminate\Support\{Facades\Gate, Facades\Route, ServiceProvider};
use NS\User\Middlewares\CurrentUserProfile;
use NS\User\Models\User;
use NS\User\Policies\UserProfilePolicy;

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
        $this->addRegistrationRoutes();
        $this->addPasswordResetRoutes();
        $this->addProfileRoutes();

        $this->profilePolicies();

        $this->mergeConfigFrom(__DIR__.'/Config/user.php', 'user');
        $this->loadMigrationsFrom(__DIR__.'/DB/migrations');
    }

    /**
     * Profile Control routes
     * @return void
     */
    private function addRegistrationRoutes(): void
    {
        Route::prefix('user')
            ->group(static function () {
                Route::middleware([
                    'web',
                ])
                    ->name('user')
                    ->namespace('NS\User\Controllers')
                    ->group(__DIR__.'/Routes/registration_routes.php');
            });
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
                    'verified',
                    CurrentUserProfile::class,
                ])
                    ->where(['user' => '\d+?'])
                    ->name('user.profile')
                    ->namespace('NS\User\Controllers')
                    ->group(__DIR__.'/Routes/profile_routes.php');
            });
    }

    private function profilePolicies(): void
    {
        Gate::define(User::class, UserProfilePolicy::class);
    }

    private function addPasswordResetRoutes(): void
    {
        Route::middleware([
            'web',
        ])
            ->namespace('NS\User\Controllers')
            ->group(__DIR__.'/Routes/password_reset_routes.php');
    }

}
