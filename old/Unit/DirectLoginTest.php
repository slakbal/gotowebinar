<?php

namespace Slakbal\Gotowebinar\Old\Test\Unit;

use Slakbal\Gotowebinar\Old\DirectLogin;
use Slakbal\Gotowebinar\Old\Facade\GotoWebinar;
use Slakbal\Gotowebinar\Old\Test\TestCase;

class DirectLoginTest extends TestCase
{
    /**
     * Test direct login for access token
     *
     * @return void
     */
    public function testDirectLogin()
    {
        $this->assertNotEmpty((new DirectLogin)->authenticate()->access_token);
    }
}
