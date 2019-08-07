<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            base_path('assets') => public_path('assets'),
        ], 'public');
    }
}
