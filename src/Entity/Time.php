<?php

namespace Slakbal\Gotowebinar\Entity;


class Time extends EntityAbstract
{

    public $startTime;

    public $endTime;


    public function __construct($startTime, $endTime)
    {
        $this->setStart($startTime);
        $this->setEnd($endTime);
    }


    public function setStart($startTime)
    {
        $this->startTime = $startTime;
    }


    public function setEnd($endTime)
    {
        $this->endTime = $endTime;
    }
}