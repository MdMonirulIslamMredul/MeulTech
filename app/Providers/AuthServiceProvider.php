<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\ProductPolicy;
use App\Models\Product;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Product::class => ProductPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Example gate for accessing Filament or admin area
        Gate::define('access-admin', function ($user) {
            return $user->hasAnyRole(['Super Admin', 'Admin', 'Staff']);
        });
    }
}
