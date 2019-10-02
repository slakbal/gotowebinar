<?php

namespace Slakbal\Gotowebinar\Resources\Attendee;

use Slakbal\Gotowebinar\Resources\AbstractResource;

final class Attendee extends AbstractResource
{
    use AttendeeQueryParameters, AttendeeOperations;

    /** RESOURCE PATH **/
    protected $baseResourcePath = '/organizers/:organizerKey/webinars/:webinarKey/attendees';

    public function __construct()
    {
        $this->resourcePath = $this->baseResourcePath;
    }
}
