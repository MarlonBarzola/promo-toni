<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    /* public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    } */

    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(8);
        });

        Gate::define('access-admin', function (User $user) {
            return $user->rol === 'admin';
        });
    }
}
