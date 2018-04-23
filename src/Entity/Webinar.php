<?php

namespace Slakbal\Gotowebinar\Entity;


class Webinar extends EntityAbstract
{

    /* Model Schema
    {
      "subject": "string",
      "description": "string",
      "times": [
        {
          "startTime": "2017-09-20T12:00:00Z",
          "endTime": "2017-09-20T13:00:00Z"
        }
      ],
      "timeZone": "string",
      "type": "single_session",
      "isPasswordProtected": false
    }
    */

    public $subject;
    public $description;
    public $times = [];
    public $timeZone;
    public $type = 'single_session';
    public $locale;
    public $isPasswordProtected = false;


    public function __construct($parameterArray = null)
    {
        if (isset($parameterArray) && is_array($parameterArray)) {

            //required
            $this->subject = $parameterArray['subject'];
            $this->description = $parameterArray['description'];
            $this->times[] = new Time($parameterArray['startTime'], $parameterArray['endTime']);

            //optional
            $this->timeZone = $parameterArray['timeZone'] ?? config('app.timezone');
            $this->locale = $parameterArray['locale'] ?? $this->determineLocale() ?? 'en_US';
            $this->type = $parameterArray['type'] ?? $this->type;
            $this->isPasswordProtected = $parameterArray['isPasswordProtected'] ?? $this->isPasswordProtected;

        }
    }

}