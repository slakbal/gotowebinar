<?php

namespace Slakbal\Gotowebinar\Facade;

use Slakbal\Gotowebinar\Webinar;
use Illuminate\Support\Facades\Facade;

class Webinars extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Webinar::class;
    }
}
