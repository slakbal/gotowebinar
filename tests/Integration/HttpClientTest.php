<?php

namespace Slakbal\Citrix\Test\Unit;

use Slakbal\Citrix\Test\BaseFunctionalTestCase;
use Slakbal\Citrix\Webinar;

class HttpClientTest extends BaseFunctionalTestCase
{

    /** @test */
    public function it_tests_if_urls_are_properly_santized()
    {
        $webinar = new Webinar();

        $this->assertEquals('https://api.getgo.com/oauth/access_token', $webinar->getBasePath('/oauth/access_token'));
    }

}