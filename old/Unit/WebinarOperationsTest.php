<?php

namespace Slakbal\Gotowebinar\Old\Test\Unit;

use Slakbal\Gotowebinar\Old\Test\TestCase;
use Slakbal\Gotowebinar\Old\Facade\GotoWebinar;

class WebinarOperationsTest extends TestCase
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
