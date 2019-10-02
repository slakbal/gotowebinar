<?php

namespace Slakbal\Gotowebinar\Facade;

use Illuminate\Support\Facades\Facade;
use Slakbal\Gotowebinar\Resources\Attendee\Attendee;

class Attendees extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Attendee::class;
    }
}
