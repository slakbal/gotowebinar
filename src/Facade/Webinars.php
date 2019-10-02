<?php

namespace Slakbal\Gotowebinar\Facade;

use Illuminate\Support\Facades\Facade;
use Slakbal\Gotowebinar\Resources\Webinar\Webinar;

class Webinars extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Webinar::class;
    }
}
