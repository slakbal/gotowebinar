<?php

namespace Slakbal\Gotowebinar\Resources;

use Carbon\Carbon;

class Time
{
    /* Model Schema
    {
      "startTime": "2017-09-20T12:00:00Z",
      "endTime": "2017-09-20T13:00:00Z"
    }
    */

    public $startTime;

    public $endTime;

    public function __construct(Carbon $startTime, Carbon $endTime)
    {
        $this->startTime = $startTime->toW3cString();
        $this->endTime = $endTime->toW3cString();
    }
}
