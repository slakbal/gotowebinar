<?php

namespace Slakbal\Gotowebinar;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Slakbal\Gotowebinar\Resources\Session\Session;
use Slakbal\Gotowebinar\Resources\Webinar\Webinar;
use Slakbal\Gotowebinar\Resources\Attendee\Attendee;
use Slakbal\Gotowebinar\Resources\Registrant\Registrant;

class GotoWebinarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * @return void
     */
    public function boot()
    {
        if (! App::environment('production')) {
            $this->loadRoutesFrom(__DIR__.'/Routes/routes.php');
        }

        $this->publishes([__DIR__.'/../config/goto.php' => config_path('goto.php')], 'config');
    }

    public function register()
    {
        //runtime merge config
        $this->mergeConfigFrom(__DIR__.'/../config/goto.php', 'goto');

        $this->app->bind(Webinar::class, function () {
            return new Webinar();
        });

        $this->app->bind(Registrant::class, function () {
            return new Registrant();
        });

        $this->app->bind(Session::class, function () {
            return new Session();
        });

        $this->app->bind(Attendee::class, function () {
            return new Attendee();
        });
    }
}
