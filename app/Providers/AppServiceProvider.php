<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        Gate::define('is-staff', function (User $user) {
            return $user->role === 'staff';
        });

        Gate::define('is-admin', function (User $user) {
            return $user->role === 'staff' && $user->division === 'admin';
        });

        Gate::define('is-web-dev', function (User $user) {
            return $user->role === 'staff' && $user->division === 'web_dev';
        });

        Gate::define('is-designer', function (User $user) {
            return $user->role === 'staff' && $user->division === 'designer';
        });
    }
}
