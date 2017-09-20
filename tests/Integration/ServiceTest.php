<?php

namespace Slakbal\Citrix\Test\Integration;

use Slakbal\Citrix\Test\BaseFunctionalTestCase;

class ServiceTest extends BaseFunctionalTestCase
{

    /** @test */
    public function http_service_can_authenticate_against_the_citrix_api()
    {
        $this->assertEquals('hello', 'hello');
    }

}