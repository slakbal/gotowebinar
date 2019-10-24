<?php

namespace Slakbal\Gotowebinar\Resources\Webinar;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Slakbal\Gotowebinar\Resources\Time;
use Slakbal\Gotowebinar\Resources\Timezone;
use Slakbal\Gotowebinar\Resources\EmailSettings;
use Slakbal\Gotowebinar\Resources\AbstractResource;

final class Webinar extends AbstractResource
{
    use WebinarQueryParameters, WebinarOperations;

    /* CREATE SCHEMA *required
    {
      * "subject": "string",
      * "times": [
        {
          "startTime": "2019-08-02T09:30:29.290Z",
          "endTime": "2019-08-02T09:30:29.290Z"
        }
      ],
      "description": "string",
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

    /** PAYLOAD PROPERTIES */
    protected $subject;

    protected $description;

    protected $times = [];

    protected $timeZone;

    protected $type = 'single_session';

    protected $locale;

    protected $isPasswordProtected = false;

    protected $experienceType = 'CLASSIC';

    protected $emailSettings;

    /**
     * EXPLICITLY EXCLUDE THIS TEMP STATE FROM
     * THE PAYLOAD CALCULATION VIA PRIVATE SCOPE.
     */
    private $emailConfirmation = true;

    private $emailAbsenteeFollowUp = true;

    private $emailAttendeeFollowUp = true;

    private $emailReminder = true;

    private $includeCertificate = true;

    protected $baseResourcePath = '/organizers/:organizerKey/webinars';

    public function __construct()
    {
        $this->resourcePath = $this->baseResourcePath;

        $this->locale();
    }

    /** OVERRIDES ABSTRACT **/
    protected function requiredFields(): array
    {
        return ['subject', 'times'];
    }

    /**
     * Set the subject.
     *
     * @param string $subject
     * @return \Slakbal\Gotowebinar\Objects\Webinar
     */
    public function subject($subject): self
    {
        $suffix = config('goto.subject_suffix');

        if (! empty($suffix)) {
            $suffix_length = Str::length($suffix);
            $subject_length = Str::length($subject);
            $maxLength = (128 - 3);

            if (($suffix_length + $subject_length) > $maxLength) {
                $this->subject = Str::limit($subject, (128 - ($suffix_length + 3)), $suffix.'...');
            } else {
                $this->subject = $subject.$suffix;
            }
        } else {
            $this->subject = Str::limit($subject, (128 - 3), '...');
        }

        return $this;
    }

    /**
     * Set the description.
     *
     * @param string $description
     * @return $this
     */
    public function description($description = null): self
    {
        $this->description = Str::limit($description, (2048 - 3), '...');

        return $this;
    }

    /**
     * Set the start and end dateTime Carbon Object.
     *
     * @param Carbon $startTime , $endTime
     * @return $this
     */
    public function times(Carbon $startTime, Carbon $endTime): self
    {
        return $this->timeFromTo($startTime, $endTime);
    }

    /**
     * Set the start and end dateTime Carbon Object.
     *
     * @param Carbon $startTime , $endTime
     * @return $this
     */
    public function timeFromTo(Carbon $startTime, Carbon $endTime): self
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
    public function timeZone($timezone = null): self
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
    public function locale($locale = null): self
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
    public function type($type = 'single_session'): self
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
    public function experienceType($type = 'CLASSIC'): self
    {
        $this->experienceType = $type;

        return $this;
    }

    /**
     * Set the if webinar is password protected.
     *
     * @return $this
     */
    public function isPasswordProtected(): self
    {
        $this->isPasswordProtected = true;

        return $this;
    }

    /**
     * Set the object.
     *
     * @return \Slakbal\Gotowebinar\Objects\Webinar
     */
    public function setEmailSettings(): self
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
    public function singleSession(): self
    {
        $this->type('single_session');

        return $this;
    }

    /**
     * Set the experience type to classic.
     *
     * @return $this
     */
    public function classic(): self
    {
        $this->experienceType('CLASSIC');

        return $this;
    }

    /**
     * Set the experience type to broadcast.
     *
     * @return $this
     */
    public function broadcast(): self
    {
        $this->experienceType('BROADCAST');

        return $this;
    }

    /**
     * Set the experience type to simulive.
     *
     * @return $this
     */
    public function simulive(): self
    {
        $this->experienceType('SIMULIVE');

        return $this;
    }

    /**
     * Confirmation email.
     *
     * @return $this
     */
    public function emailConfirmation(): self
    {
        $this->emailConfirmation = true;

        $this->setEmailSettings(); //recreate a new value object

        return $this;
    }

    /**
     * No confirmation email.
     *
     * @return $this
     */
    public function noEmailConfirmation(): self
    {
        $this->emailConfirmation = false;

        $this->setEmailSettings(); //recreate a new value object

        return $this;
    }

    /**
     * Reminder email.
     *
     * @return $this
     */
    public function emailReminder(): self
    {
        $this->emailReminder = true;

        $this->setEmailSettings(); //recreate a new value object

        return $this;
    }

    /**
     * No reminder email.
     *
     * @return $this
     */
    public function noEmailReminder(): self
    {
        $this->emailReminder = false;

        $this->setEmailSettings(); //recreate a new value object

        return $this;
    }

    /**
     * Absentee Follow up email.
     *
     * @return $this
     */
    public function emailAbsenteeFollowUp(): self
    {
        $this->emailAbsenteeFollowUp = true;

        $this->setEmailSettings(); //recreate a new value object

        return $this;
    }

    /**
     * No Absentee Follow up email.
     *
     * @return $this
     */
    public function noEmailAbsenteeFollowUp(): self
    {
        $this->emailAbsenteeFollowUp = false;

        $this->setEmailSettings(); //recreate a new value object

        return $this;
    }

    /**
     * Send attendee FollowUp email and if certificate should be included.
     *
     * @return $this
     */
    public function emailAttendeeFollowUp($includeCertificate = true): self
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
    public function noEmailAttendeeFollowUp(): self
    {
        $this->emailAttendeeFollowUp = false;

        $this->includeCertificate = false;

        $this->setEmailSettings();

        return $this;
    }
}
