<?php

namespace Slakbal\Gotowebinar\Facade;

use Illuminate\Support\Facades\Facade;
use Slakbal\Gotowebinar\Resources\Session\Session;

class Sessions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Session::class;
    }
}
