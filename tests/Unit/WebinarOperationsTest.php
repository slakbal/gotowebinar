<?php

namespace Slakbal\Gotowebinar\Test\Unit;

use Slakbal\Gotowebinar\Test\BaseTestCase;
use Slakbal\Gotowebinar\Facade\GotoWebinar;

class WebinarOperationsTest extends BaseTestCase
{
    /**
     * Get all webinars in the account, then test for a count of webinars
     * @return void
     */
    public function testGetAllWebinars()
    {
        $this->assertNotEmpty(GotoWebinar::getAllWebinars());
    }
}
