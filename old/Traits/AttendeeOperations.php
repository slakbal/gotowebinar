<?php

namespace Slakbal\Gotowebinar\Old\Traits;


trait AttendeeOperations
{

    /*
     * Retrieve details for all attendees of a specific webinar session.
    */
    function getAttendees($webinarKey, $sessionKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/sessions/%s/attendees', $webinarKey, $sessionKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Retrieve registration details for a particular attendee of a specific webinar session.
     */
    function getAttendee($webinarKey, $sessionKey, $registrantKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/sessions/%s/attendees/%s', $webinarKey, $sessionKey, $registrantKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /**
     * [getAttendeePollAnswers description]
     *
     * @param  [type] $webinarKey    [description]
     * @param  [type] $sessionKey    [description]
     * @param  [type] $registrantKey [description]
     *
     * @return [type]                [description]
     */
    public function getAttendeePollAnswers($webinarKey, $sessionKey, $registrantKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/sessions/%s/attendees/%s/polls', $webinarKey, $sessionKey, $registrantKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }

    /**
     * [getAttendeeQuestions description]
     * 
     * @param  [type] $webinarKey    [description]
     * @param  [type] $sessionKey    [description]
     * @param  [type] $registrantKey [description]
     * 
     * @return [type]                [description]
     */
    public function getAttendeeQuestions($webinarKey, $sessionKey, $registrantKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/sessions/%s/attendees/%s/questions', $webinarKey, $sessionKey, $registrantKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }
}
