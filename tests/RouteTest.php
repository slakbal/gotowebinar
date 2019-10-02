<?php

namespace Slakbal\Gotowebinar\Tests;

class RouteTest extends \Orchestra\Testbench\TestCase
{
    /** @test */
    public function visit_test_route()
    {
        $response = $this->get('_goto/ping');

        $response->assertStatus(200);
    }
}
