<?php

namespace Slakbal\Gotowebinar;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class GotoWebinarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/Routes/gotowebinar.php');

        if (! App::environment('production')) {
            $this->loadRoutesFrom(__DIR__.'/Routes/test.php');
        }

        $this->publishes([__DIR__.'/../config/gotowebinar.php' => config_path('gotowebinar.php')], 'config');
    }

    public function register()
    {
        //runtime merge config
        $this->mergeConfigFrom(__DIR__.'/../config/gotowebinar.php', 'gotowebinar');
    }
}
