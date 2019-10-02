<?php

namespace Slakbal\Gotowebinar\Resources\Session;

use Slakbal\Gotowebinar\Resources\AbstractResource;

final class Session extends AbstractResource
{
    use SessionQueryParameters, SessionOperations;

    /** RESOURCE PATH **/
    protected $baseResourcePath = '/organizers/:organizerKey/webinars/:webinarKey/sessions';

    public function __construct()
    {
        $this->resourcePath = $this->baseResourcePath;
    }
}
