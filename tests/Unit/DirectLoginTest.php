<?php

namespace Slakbal\Gotowebinar\Test\Unit;

use Slakbal\Gotowebinar\DirectLogin;
use Slakbal\Gotowebinar\Facade\GotoWebinar;
use Slakbal\Gotowebinar\Test\BaseTestCase;

class DirectLoginTest extends BaseTestCase
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
