<?php

namespace Slakbal\Gotowebinar;

use Illuminate\Support\ServiceProvider;

class GotoWebinarServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false; //must be false for the routes to work


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Routes/routes.php');

        $this->publishes([__DIR__ . '/../config/goto.php' => config_path('goto.php')], 'config');

    }


    public function register()
    {
        //runtime merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/goto.php', 'goto');

        $this->registerGotoWebinar(config('goto.auth_type'));
    }


    public function registerGotoWebinar($authType = 'direct')
    {
        $this->app->singleton(Webinar::class, function ($app) use ($authType) {
            return new Webinar($authType);
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Webinar::class,
        ];
    }
}