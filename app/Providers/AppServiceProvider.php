<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Blade::if('hasStartedSeries', function($series) {
            return auth()->user()->hasStartedSeries($series);
        });

        Blade::if('admin', function() {
            return auth()->user()->isAdmin();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
