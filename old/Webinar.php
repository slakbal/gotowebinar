<?php

namespace Slakbal\Gotowebinar;

use Slakbal\Gotowebinar\Old\Traits\AttendeeOperations;
use Slakbal\Gotowebinar\Old\Traits\RegistrantOperations;
use Slakbal\Gotowebinar\Old\Traits\SessionOperations;
use Slakbal\Gotowebinar\Old\Traits\WebinarOperations;

class Webinar extends GotoAbstract
{
    use WebinarOperations, RegistrantOperations, SessionOperations, AttendeeOperations;

    public function __construct($authType = 'direct')
    {
        parent::__construct($authType = 'direct');
    }
}
