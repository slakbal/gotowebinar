<?php

namespace Slakbal\Gotowebinar\Traits;

use Slakbal\Gotowebinar\Entity\Webinar as WebinarEntity;

trait WebinarOperations
{

    /*
     * Retrieves the list of webinars for an account within a given date range.
     * Page and size parameters are optional.
     * Default page is 0 and default size is 20.
     */
    function getAllWebinars($parameters = null)
    {
        $path = $this->getPathRelativeToOrganizer('webinars');

        return $this->sendRequest('GET', $path, $parameters, $payload = null);
    }


    /*
     * Returns webinars scheduled for the future for the configured organizer and webinars
     * of other organizers where the configured organizer is a co-organizer.
     */
    function getUpcomingWebinars()
    {
        $path = $this->getPathRelativeToOrganizer('upcomingWebinars');

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Returns details for completed webinars.
     */
    function getHistoricalWebinars($parameters = null)
    {
        $path = $this->getPathRelativeToOrganizer('historicalWebinars');

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
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s', $webinarKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Creates a single session webinar.
     * The response provides a numeric webinarKey in string format for the new webinar. Once a webinar has been created with this method, you can accept registrations.
     */
    function createWebinar($payloadArray)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars'));

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

        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s', $webinarKey));

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

        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s', $webinarKey));

        return $this->sendRequest('DELETE', $path, $parameters, $payload = null);
    }
}