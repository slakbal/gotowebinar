<?php

namespace Slakbal\Gotowebinar\Facade;

use Illuminate\Support\Facades\Facade;
use Slakbal\Gotowebinar\Resources\Registrant\Registrant;

class Registrants extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Registrant::class;
    }
}
