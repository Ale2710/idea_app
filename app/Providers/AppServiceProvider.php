<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        // Definir el gate para verificar si el usuario es admin
        Gate::define('isAdmin', function ($user) {
            return $user->role === 'admin';
        });
    }
}
