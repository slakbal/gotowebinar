<?php

namespace Slakbal\Gotowebinar\Facade;

use Slakbal\Gotowebinar\Registrant;
use Illuminate\Support\Facades\Facade;

class Registrants extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Registrant::class;
    }
}
