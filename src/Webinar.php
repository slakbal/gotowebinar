<?php

namespace Slakbal\Gotowebinar;

use Slakbal\Gotowebinar\Traits\AttendeeOperations;
use Slakbal\Gotowebinar\Traits\RegistrantOperations;
use Slakbal\Gotowebinar\Traits\SessionOperations;
use Slakbal\Gotowebinar\Traits\WebinarOperations;

class Webinar extends GotoAbstract
{

    use WebinarOperations, RegistrantOperations, SessionOperations, AttendeeOperations;


    function __construct($authType = 'direct')
    {
        parent::__construct($authType = 'direct');
    }

}
