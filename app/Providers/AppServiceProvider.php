<?php

namespace App\Providers;

use App\Models\Post;
use App\Observers\PostObserver;
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
        // 1. Registro de Observers
        // Esto permite que la Práctica 5 (Auditoría) funcione automáticamente
        Post::observe(PostObserver::class);

        // 2. Definición de Gates (Permisos de Usuario)
        
        // Gate para ver el dashboard: admin y editores pueden entrar
        Gate::define('view-dashboard', function ($user) {
            return $user->hasRole('admin') || $user->hasRole('editor');
        });

        // Gate para editar posts: admin y editores
        Gate::define('edit-post', function ($user) {
            return $user->hasRole('admin') || $user->hasRole('editor');
        });

        // Gate para eliminar posts: SOLO el admin tiene permiso
        Gate::define('delete-post', function ($user) {
            return $user->hasRole('admin');
        });
    }
}