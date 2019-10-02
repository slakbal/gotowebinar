<?php

namespace Slakbal\Gotowebinar\Resources\Attendee;

/*
 * Operations available for attendees of a given webinar session.
 */

trait AttendeeOperations
{
    /**
     * Set the webinar key.
     */
    public function webinarKey($webinarKey): self
    {
        $this->pathKeys['webinarKey'] = $webinarKey;

        return $this;
    }

    /**
     * Set the session key.
     */
    public function sessionKey($sessionKey): self
    {
        $this->pathKeys['sessionKey'] = $sessionKey;

        return $this;
    }

    /**
     * Set the registrant key.
     */
    public function registrantKey($registrantKey): self
    {
        $this->pathKeys['registrantKey'] = $registrantKey;

        $this->resourcePath = $this->baseResourcePath.'/:registrantKey';

        return $this;
    }

    /**
     * Set the polls path.
     */
    public function polls(): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:registrantKey/polls';

        return $this;
    }

    /**
     * Set the questions path.
     */
    public function questions(): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:registrantKey/questions';

        return $this;
    }

    /**
     * Set the surveys path.
     */
    public function surveys(): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:registrantKey/surveys';

        return $this;
    }
}
