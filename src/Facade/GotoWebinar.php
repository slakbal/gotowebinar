<?php

namespace Slakbal\Gotowebinar\Facade;

use Illuminate\Support\Facades\Facade;
use Slakbal\Gotowebinar\Webinar;

class GotoWebinar extends Facade
{

    protected static function getFacadeAccessor()
    {
        return Webinar::class;
    }
}