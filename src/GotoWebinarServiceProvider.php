<?php

namespace Slakbal\Gotowebinar;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class GotoWebinarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * @return void
     */
    public function boot()
    {
        if (! App::environment('production')) {
            $this->loadRoutesFrom(__DIR__ . '/Routes/routes.php');
        } else {
            $this->defer = true;
        }

        $this->publishes([__DIR__ . '/../config/goto.php' => config_path('goto.php')], 'config');
    }


    public function register()
    {
        //runtime merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/goto.php', 'goto');

        $this->app->bind(Webinar::class, function () {
            return new Webinar();
        });

        $this->app->bind(Registrant::class, function () {
            return new Registrant();
        });

//
//        $this->app->singleton(RegistrantResource::class, function ($app) {
//            return new RegistrantResource();
//        });
    }


    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return [
            Webinar::class,
        ];
    }

}