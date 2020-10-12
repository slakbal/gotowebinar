<?php

namespace Slakbal\Gotowebinar;

use Illuminate\Support\ServiceProvider;
use Slakbal\Gotowebinar\Commands\GoToAccessTokenCommand;
use Slakbal\Gotowebinar\Commands\GoToAuthorizeLinkCommand;
use Slakbal\Gotowebinar\Commands\GoToGenerateLinkCommand;
use Slakbal\Gotowebinar\Resources\Attendee\Attendee;
use Slakbal\Gotowebinar\Resources\Registrant\Registrant;
use Slakbal\Gotowebinar\Resources\Session\Session;
use Slakbal\Gotowebinar\Resources\Webinar\Webinar;

class GotoWebinarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * @return void
     */
    public function boot()
    {
        if (! $this->app->environment('production')) {
            $this->loadRoutesFrom(__DIR__.'/Routes/routes.php');
        }

        $this->publishes([__DIR__.'/../config/goto.php' => config_path('goto.php')], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                GoToGenerateLinkCommand::class,
                GoToAccessTokenCommand::class
            ]);
        }
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
