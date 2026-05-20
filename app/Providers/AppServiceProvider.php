<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // Gate para ver el dashboard
        Gate::define('view-dashboard', function ($user) {
            return $user->hasRole('admin') || $user->hasRole('editor');
        });

        // Gate para editar posts
        Gate::define('edit-post', function ($user) {
            return $user->hasRole('admin') || $user->hasRole('editor');
        });

        // Gate para eliminar posts
        Gate::define('delete-post', function ($user) {
            return $user->hasRole('admin');
        });
    }
}