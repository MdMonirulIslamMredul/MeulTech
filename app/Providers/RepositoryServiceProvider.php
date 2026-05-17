<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind repository interfaces to implementations here, e.g.
        // $this->app->bind(\App\Repositories\Contracts\ProductRepositoryInterface::class, \App\Repositories\Eloquent\ProductRepository::class);
    }

    public function boot()
    {
        // Load helper functions (authorization helpers)
        $helper = dirname(__DIR__) . '/Helpers/authorization.php';

        if (file_exists($helper)) {
            require_once $helper;
        }
    }
}
