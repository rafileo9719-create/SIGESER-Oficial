<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // <-- Importante
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Permisos para el menú de AdminLTE
        Gate::define('ver-dependencias', function (User $user) {
            return $user->hasRole('admin') || $user->hasRole('encargado');
        });

        Gate::define('ver-carreras', function (User $user) {
            return $user->hasRole('admin') || $user->hasRole('encargado');
        });

        Gate::define('ver-docentes', function (User $user) {
            return $user->hasRole('admin') || $user->hasRole('encargado');
        });
    }
}
