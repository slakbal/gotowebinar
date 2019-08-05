<?php

namespace Slakbal\Gotowebinar\Objects;

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


    public function __construct($startTime, $endTime)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

}