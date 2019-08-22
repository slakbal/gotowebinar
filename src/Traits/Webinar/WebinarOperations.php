<?php

namespace Slakbal\Gotowebinar\Traits\Webinar;

use Slakbal\Gotowebinar\Objects\Webinar;

trait WebinarOperations
{
    /*
     * Retrieves the list of webinars for an account within a given date range.
     * Page and size parameters are optional. Default page is 0 and default size is 20.
     */
    public function getAccountWebinars($parameters = null)
    {
        $path = $this->getPathRelativeToAccount('webinars');

        return $this->sendAPIRequest('GET', $path, $parameters);
    }


    /*
     * Returns upcoming and past webinars for the currently authenticated organizer
     * that are scheduled within the specified date/time range. Page and size
     * parameters are optional. Default page is 0 and default size is 20.
     */
    public function getWebinars($parameters = null)
    {
        $path = $this->getPathRelativeToOrganizer('webinars');

        return $this->sendAPIRequest('GET', $path, $parameters);
    }


    /*
     * Retrieve information on a specific webinar. If the type of the webinar is 'sequence', a sequence
     * of future times will be provided. Webinars of type 'series' are treated the same as normal
     * webinars - each session in the webinar series has a different webinarKey. If an organizer cancels a webinar,
     * then a request to get that webinar would return a '404 Not Found' error.
     */
    function getWebinar($webinarKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s', $webinarKey));

        return $this->sendAPIRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Creates a single session webinar.
     * The response provides a numeric webinarKey in string format for the newly created webinar.
     * Once a webinar has been created with this method, you can accept registrations to it via the webinarKey.
     */
    function createWebinar(Webinar $webinarObject)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars'));

        return $this->sendAPIRequest('POST', $path, $parameters = null, $webinarObject);
    }


    /*
     * Updates a webinar. The call requires at least one of the parameters in the request body.
     * The request completely replaces the existing session, series, or sequence and so must include
     * the full definition of each as for the Create call.
     *
     * S$notifyParticipants - Indicates if update emails should be sent to registrants. Default is true.
     */
    function updateWebinar($webinarKey, Webinar $webinarObject, $notifyParticipants = true)
    {
        ($notifyParticipants) ? $parameters = ['notifyParticipants' => true] : $parameters = ['notifyParticipants' => false];

        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s', $webinarKey));

        return $this->sendAPIRequest('PUT', $path, $parameters, $webinarObject);
    }


    /*
     * Cancels a specific webinar. If the webinar is a series or sequence, this call deletes all scheduled sessions.
     * To send cancellation emails to registrants set sendCancellationEmails=true in the request.
     * When the cancellation emails are sent, the default generated message is used in the cancellation email body.
     *
     * $sendCancellationEmails - Indicates whether cancellation notice emails should be sent. The default value is false.
     */
    function deleteWebinar($webinarKey, $sendCancellationEmails = false)
    {
        ($sendCancellationEmails) ? $parameters = ['sendCancellationEmails' => true] : $parameters = null;

        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s', $webinarKey));

        return $this->sendAPIRequest('DELETE', $path, $parameters, $payload = null);
    }

}