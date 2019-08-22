<?php

namespace Slakbal\Gotowebinar\Traits\Attendee;

trait AttendeeOperations
{
    /*
     * Returns all attendees for all sessions of the specified webinar.
     */
    function getAttendees($webinarKey, $parameters = null)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/attendees', $webinarKey));

        return $this->sendAPIRequest('GET', $path, $parameters, $payload = null);
    }
}