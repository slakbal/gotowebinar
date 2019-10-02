<?php

namespace Slakbal\Gotowebinar\Resources\Webinar;

trait WebinarOperations
{
    /**
     * Set the webinards by account key and path.
     */
    public function byAccountKey(): self
    {
        $this->resourcePath = '/accounts/:accountKey/webinars';

        return $this;
    }

    /**
     * Set the webinar key and path.
     *
     * @param string $subject
     * @return \Slakbal\Gotowebinar\Objects\Webinar
     */
    public function webinarKey($webinarKey): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:webinarKey';

        $this->pathKeys['webinarKey'] = $webinarKey;

        return $this;
    }

    /**
     * Set the insessionWebinars path.
     */
    public function insessionWebinars(): self
    {
        $this->resourcePath = '/organizers/:organizerKey/insessionWebinars';

        return $this;
    }

    /**
     * Set the attendees path.
     */
    public function attendees(): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:webinarKey/attendees';

        return $this;
    }

    /**
     * Set the meetingTimes path.
     */
    public function meetingTimes(): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:webinarKey/meetingtimes';

        return $this;
    }

    /**
     * Set the audio path.
     */
    public function audio(): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:webinarKey/audio';

        return $this;
    }

    /**
     * Set the performance path.
     */
    public function performance(): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:webinarKey/performance';

        return $this;
    }
}
