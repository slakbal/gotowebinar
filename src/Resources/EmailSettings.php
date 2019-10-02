<?php

namespace Slakbal\Gotowebinar\Resources;

class EmailSettings
{
    /* Model Schema
        "confirmationEmail": {
          "enabled": true
        },
        "reminderEmail": {
          "enabled": true
        },
        "absenteeFollowUpEmail": {
          "enabled": true
        },
        "attendeeFollowUpEmail": {
          "enabled": true,
          "includeCertificate": true
        }
    */

    public $confirmationEmail;

    public $reminderEmail;

    public $absenteeFollowUpEmail;

    public $attendeeFollowUpEmail;

    public function __construct($confirmationEmail = true, $reminderEmail = true, $absenteeFollowUpEmail = true, $attendeeFollowUpEmail = true, $includeCertificate = true)
    {
        $this->confirmationEmail = (object) [
            'enabled' => $confirmationEmail,
        ];

        $this->reminderEmail = (object) [
            'enabled' => $reminderEmail,
        ];

        $this->absenteeFollowUpEmail = (object) [
            'enabled' => $absenteeFollowUpEmail,
        ];

        $this->attendeeFollowUpEmail = (object) [
            'enabled' => $attendeeFollowUpEmail,
            'includeCertificate' => $includeCertificate,
        ];
    }
}
