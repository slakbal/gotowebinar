<?php


namespace Slakbal\Gotowebinar;

use Slakbal\Gotowebinar\Entity\Attendee;
use Slakbal\Gotowebinar\Entity\Webinar as WebinarEntity;

class Webinar extends GotoAbstract
{

    function __construct($authType = 'direct')
    {
        parent::__construct($authType = 'direct');
    }


    /*
     * Retrieves the list of webinars for an account within a given date range.
     * Page and size parameters are optional.
     * Default page is 0 and default size is 20.
     */
    function getAllWebinars($parameters = null)
    {
        $path = 'organizers/' . $this->getOrganizerKey() . '/webinars';

        return $this->sendRequest('GET', $path, $parameters, $payload = null);
    }


    /*
     * Returns webinars scheduled for the future for the configured organizer and webinars
     * of other organizers where the configured organizer is a co-organizer.
     */
    function getUpcomingWebinars()
    {
        $path = 'organizers/' . $this->getOrganizerKey() . '/upcomingWebinars';

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Returns details for completed webinars.
     */
    function getHistoricalWebinars($parameters = null)
    {
        $path = 'organizers/' . $this->getOrganizerKey() . '/historicalWebinars';

        return $this->sendRequest('GET', $path, $parameters, $payload = null);
    }


    /*
     * Retrieve information on a specific webinar.
     * If the type of the webinar is 'sequence', a sequence of future times will be provided.
     * Webinars of type 'series' are treated the same as normal webinars - each session in the webinar series has a different webinarKey.
     * If an organizer cancels a webinar, then a request to get that webinar would return a '404 Not Found' error.
     */
    function getWebinar($webinarKey)
    {
        $path = 'organizers/' . $this->getOrganizerKey() . '/webinars/' . $webinarKey;

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Creates a single session webinar.
     * The response provides a numeric webinarKey in string format for the new webinar. Once a webinar has been created with this method, you can accept registrations.
     */
    function createWebinar($payloadArray)
    {
        $path = 'organizers/' . $this->getOrganizerKey() . '/webinars';

        $webinarObject = new WebinarEntity($payloadArray);

        return $this->sendRequest('POST', $path, $parameters = null, $payload = $webinarObject->toArray());
    }


    /*
     * Updates a webinar. The call requires at least one of the parameters in the request body.
     * The request completely replaces the existing session, series, or sequence and so must include the full
     * definition of each as for the Create call. Set notifyParticipants=true to send update emails to registrants.
     */
    function updateWebinar($webinarKey, $payloadArray, $sendNotification = true)
    {
        ($sendNotification) ? $parameters = ['notifyParticipants' => true] : $parameters = ['notifyParticipants' => false];

        $path = 'organizers/' . $this->getOrganizerKey() . '/webinars/' . $webinarKey;

        $webinarObject = new WebinarEntity($payloadArray);

        return $this->sendRequest('PUT', $path, $parameters, $payload = $webinarObject->toArray());
    }


    /*
     * Cancels a specific webinar. If the webinar is a series or sequence, this call deletes all scheduled sessions.
     * To send cancellation emails to registrants set sendCancellationEmails=true in the request. The default value is false.
     * When the cancellation emails are sent, the default generated message is used in the cancellation email body.
     */
    function deleteWebinar($webinarKey, $sendCancellationEmails = true)
    {
        ($sendCancellationEmails) ? $parameters = ['sendCancellationEmails' => true] : $parameters = null;

        $path = 'organizers/' . $this->getOrganizerKey() . '/webinars/' . $webinarKey;

        return $this->sendRequest('DELETE', $path, $parameters, $payload = null);
    }


    /*
     * Register an attendee for a scheduled webinar. The response contains the registrantKey and join URL for the registrant.
     * An email will be sent to the registrant unless the organizer turns off the confirmation email setting from the GoToWebinar website.
     * resendConfirmation - Indicates whether the confirmation email should be resent when a registrant is re-registered. The default value is false.
     *
     * Version 1 of this API call is used. Thus it explicitly excludes the header 'Accept: application/vnd.citrix.g2wapi-v1.1+json'
     *
     */
    function createRegistrant($webinarKey, $payloadArray, $resendConfirmation = false)
    {
        ($resendConfirmation) ? $parameters = ['resendConfirmation' => true] : $parameters = ['resendConfirmation' => false];

        $path = 'organizers/' . $this->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants';

        $attendeeObject = new Attendee($payloadArray);

        return $this->sendRequest('POST', $path, $parameters, $payload = $attendeeObject->toArray());
    }


    /*
     * Retrieve registration details for all registrants of a specific webinar.
     * Registrant details will not include all fields captured when creating the registrant.
     * To see all data, use the API call 'Get Registrant'. Registrants can have one of the following states;
     * WAITING - registrant registered and is awaiting approval (where organizer has required approval),
     * APPROVED - registrant registered and is approved, and
     * DENIED - registrant registered and was denied.
     */
    function getRegistrants($webinarKey)
    {
        $path = 'organizers/' . $this->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants';

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Retrieve registration details for a specific registrant.
     */
    function getRegistrant($webinarKey, $registrantKey)
    {
        $path = 'organizers/' . $this->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants/' . $registrantKey;

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Removes a webinar registrant from current registrations for the specified webinar. The webinar must be a scheduled, future webinar.
     */
    function deleteRegistrant($webinarKey, $registrantKey)
    {
        $path = 'organizers/' . $this->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants/' . $registrantKey;

        return $this->sendRequest('DELETE', $path, $parameters = null, $payload = null);
    }

    //TODO CARRY ON HERE


    /*
     * Retrieves details for all past sessions of a specific webinar.
     */
    //function getSessions($webinarKey)
    //{
    //    $path = 'organizers/' . $this->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions';
    //
    //    return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    //}


    /*
     * Retrieves attendance details for a specific webinar session that has ended.
     * If attendees attended the session ('registrantsAttended'), specific attendance details, such as
     * attendenceTime for a registrant, will also be retrieved. For technical reasons, this call cannot
     * be executed from this documentation. Please use the curl command to execute it.
     */
    //function getSession($webinarKey, $sessionKey)
    //{
    //    $path = 'organizers/' . $this->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions/' . $sessionKey;
    //
    //    return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    //}


    /*
     * Returns all attendees for all sessions of the specified webinar.
     */
    function getAttendees($webinarKey)
    {
        $path = 'organizers/' . $this->getOrganizerKey() . '/webinars/' . $webinarKey . '/attendees';

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    function getAttendee($webinarKey, $registrantKey)
    {
        $path = 'organizers/' . $this->getOrganizerKey() . '/webinars/' . $webinarKey . '/attendees/' . $registrantKey;

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }

}
