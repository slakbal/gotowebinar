<?php

namespace Slakbal\Gotowebinar\Tests;

class RouteTest extends \Orchestra\Testbench\TestCase
{
    // Use annotation @test so that PHPUnit knows about the test
    /** @test */
    public function visit_test_route()
    {
        // Visit /test and see "Test Laravel package isolated" on it
        $response = $this->get('_goto/ping');
        $response->assertStatus(404);
    }

}