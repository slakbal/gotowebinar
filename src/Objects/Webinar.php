<?php

namespace Slakbal\Gotowebinar\Objects;

use Illuminate\Support\Str;

class Webinar extends EntityAbstract
{
    /*
    {
      "subject": "string",
      "description": "string",
      "times": [
        {
          "startTime": "2019-08-02T09:30:29.290Z",
          "endTime": "2019-08-02T09:30:29.290Z"
        }
      ],
      "timeZone": "string",
      "type": "string",
      "isPasswordProtected": false,
      "recordingAssetKey": "string",
      "isOndemand": false,
      "experienceType": "string",
      "emailSettings": {
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
      }
    }
    */

    public $subject;

    public $description;

    public $times = [];

    public $timeZone;

    public $type = 'single_session';

    public $locale = 'en_US';

    public $isPasswordProtected = false;

    public $experienceType = 'CLASSIC';

    public $emailSettings;

    //Privates are hidden from the payload to the API CLIENT

    private $emailConfirmation = true;

    private $emailAbsenteeFollowUp = true;

    private $emailAttendeeFollowUp = true;

    private $emailReminder = true;

    private $includeCertificate = true;

    public function __construct($parameterArray = null)
    {
        if (! is_null($parameterArray) && is_array($parameterArray)) {
            //required
            $this->subject($parameterArray['subject']);
            $this->description($parameterArray['description'] ?? null);
            $this->timeFromTo($parameterArray['startTime'], $parameterArray['endTime']);

            //optional
            $this->timeZone($parameterArray['timeZone'] ?? null);
            $this->locale($parameterArray['locale'] ?? null);
            $this->type($parameterArray['type'] ?? null);
            $this->experience($parameterArray['experienceType'] ?? null);

            isset($parameterArray['isPasswordProtected']) ? $parameterArray['isPasswordProtected'] ? $this->isPasswordProtected() : null : null;
        }

        $this->setEmailSettings();
    }

    /**
     * Set the subject.
     *
     * @param string $subject
     * @return $this
     */
    public function subject($subject)
    {
        $this->subject = Str::limit($subject, (128 - 3), '...');

        return $this;
    }

    /**
     * Set the description.
     *
     * @param string $description
     * @return $this
     */
    public function description($description = null)
    {
        $this->description = Str::limit($description, (2048 - 3), '...');

        return $this;
    }

    /**
     * Set the start and end time.
     *
     * @param string $startTime , $endTime
     * @return $this
     */
    public function timeFromTo($startTime, $endTime)
    {
        $this->times = [new Time($startTime, $endTime)];

        return $this;
    }

    /**
     * Set the timezone.
     *
     * @param string $timezone
     * @return $this
     */
    public function timeZone($timezone = null)
    {
        $this->timeZone = (new Timezone($timezone))->getTimezone();

        return $this;
    }

    /**
     * Set the locale.
     *
     * @param string $locale
     * @return $this
     */
    public function locale($locale = 'en_US')
    {
        $this->locale = $locale ?? $this->determineLocale() ?? 'en_US';

        return $this;
    }

    /**
     * Set the type.
     *
     * @param string $type
     * @return $this
     */
    private function type($type = 'single_session')
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the experience type.
     *
     * @param string $type
     * @return $this
     */
    public function experience($type = 'CLASSIC')
    {
        $this->experienceType = $type;

        return $this;
    }

    /**
     * Set the if webinar is password protected.
     *
     * @return $this
     */
    public function isPasswordProtected()
    {
        $this->isPasswordProtected = true;

        return $this;
    }

    /**
     * Set the object.
     *
     * @return $this
     */
    public function setEmailSettings()
    {
        //create and set an email settings object with the current state
        $this->emailSettings = new EmailSettings($this->emailConfirmation,
                                                 $this->emailReminder,
                                                 $this->emailAbsenteeFollowUp,
                                                 $this->emailAttendeeFollowUp,
                                                 $this->includeCertificate);

        return $this;
    }

    /**
     * Set the type to single session.
     *
     * @return $this
     */
    public function singleSession()
    {
        $this->type('single_session');

        return $this;
    }

    /**
     * Set the experience type to classic.
     *
     * @return $this
     */
    public function classic()
    {
        $this->experience('CLASSIC');

        return $this;
    }

    /**
     * Set the experience type to broadcast.
     *
     * @return $this
     */
    public function broadcast()
    {
        $this->experience('BROADCAST');

        return $this;
    }

    /**
     * Set the experience type to simulive.
     *
     * @return $this
     */
    public function simulive()
    {
        $this->experience('SIMULIVE');

        return $this;
    }

    /**
     * Confirmation email.
     *
     * @return $this
     */
    public function emailConfirmation()
    {
        $this->emailConfirmation = true;

        $this->setEmailSettings();

        return $this;
    }

    /**
     * No confirmation email.
     *
     * @return $this
     */
    public function noEmailConfirmation()
    {
        $this->emailConfirmation = false;

        $this->setEmailSettings();

        return $this;
    }

    /**
     * Reminder email.
     *
     * @return $this
     */
    public function emailReminder()
    {
        $this->emailReminder = true;

        $this->setEmailSettings();

        return $this;
    }

    /**
     * No reminder email.
     *
     * @return $this
     */
    public function noEmailReminder()
    {
        $this->emailReminder = false;

        $this->setEmailSettings();

        return $this;
    }

    /**
     * Absentee Follow up email.
     *
     * @return $this
     */
    public function emailAbsenteeFollowUp()
    {
        $this->emailAbsenteeFollowUp = true;

        $this->setEmailSettings();

        return $this;
    }

    /**
     * No Absentee Follow up email.
     *
     * @return $this
     */
    public function noEmailAbsenteeFollowUp()
    {
        $this->emailAbsenteeFollowUp = false;

        $this->setEmailSettings();

        return $this;
    }

    /**
     * Send attendee FollowUp email and if certificate should be included.
     *
     * @return $this
     */
    public function emailAttendeeFollowUp($includeCertificate = true)
    {
        $this->emailAttendeeFollowUp = true;

        $this->includeCertificate = $includeCertificate;

        $this->setEmailSettings();

        return $this;
    }

    /**
     * No attendee FollowUp email.
     *
     * @return $this
     */
    public function noEmailAttendeeFollowUp()
    {
        $this->emailAttendeeFollowUp = false;

        $this->includeCertificate = false;

        $this->setEmailSettings();

        return $this;
    }
}
