<?php

namespace Slakbal\Gotowebinar;

use Slakbal\Gotowebinar\Traits\Client\Client;
use Slakbal\Gotowebinar\Traits\Registrant\RegistrantOperations;
use Slakbal\Gotowebinar\Traits\Session\SessionOperations;
use Slakbal\Gotowebinar\Traits\Webinar\WebinarOperations;
use Slakbal\Gotowebinar\Traits\Attendee\AttendeeOperations;

class Webinar
{
    use Client, WebinarOperations, RegistrantOperations, SessionOperations, AttendeeOperations;

    const BASE_URI = 'https://api.getgo.com';
    const API_ENDPOINT = 'https://api.getgo.com/G2W/rest/v2';

    public function __construct()
    {

    }

}
