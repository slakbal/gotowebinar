<?php

namespace Slakbal\Gotowebinar\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('goto.direct.username', env('GOTO_DIRECT_USER'));
        $app['config']->set('goto.direct.password', env('GOTO_CONSUMER_SECRET'));
        $app['config']->set('goto.direct.client_id', env('GOTO_CONSUMER_KEY'));
        $app['config']->set('goto.direct.client_secret', env('GOTO_CLIENT_SECRET'));
    }
}
