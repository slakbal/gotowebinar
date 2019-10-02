<?php

namespace Slakbal\Gotowebinar\Resources\Session;

/*
 * Operations available for sessions of a given webinar.
 */

trait SessionOperations
{
    public function webinarKey($webinarKey): self
    {
        $this->pathKeys['webinarKey'] = $webinarKey;

        return $this;
    }

    /**
     * Get all the sessions of the organizer.
     */
    public function organizerSessions(): self
    {
        $this->resourcePath = '/organizers/:organizerKey/sessions';

        return $this;
    }

    /**
     * Set the session key.
     */
    public function sessionKey($sessionKey): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:sessionKey';

        $this->pathKeys['sessionKey'] = $sessionKey;

        return $this;
    }

    /**
     * Set the performance path.
     */
    public function performance(): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:sessionKey/performance';

        return $this;
    }

    /**
     * Set the polls path.
     */
    public function polls(): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:sessionKey/polls';

        return $this;
    }

    /**
     * Set the questions path.
     */
    public function questions(): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:sessionKey/questions';

        return $this;
    }

    /**
     * Set the surveys path.
     */
    public function surveys(): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:sessionKey/surveys';

        return $this;
    }
}
