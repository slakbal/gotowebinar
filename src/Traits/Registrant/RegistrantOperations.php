<?php

namespace Slakbal\Gotowebinar\Traits\Registrant;

use Slakbal\Gotowebinar\Objects\Registrant;

trait RegistrantOperations
{
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
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/registrants', $webinarKey));

        return $this->sendAPIRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Retrieve registration details for a specific registrant.
     */
    function getRegistrant($webinarKey, $registrantKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/registrants/%s', $webinarKey, $registrantKey));

        return $this->sendAPIRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Register an attendee for a scheduled webinar. The response contains the registrantKey and join URL
     * for the registrant. An email will be sent to the registrant unless the organizer turns off the
     * confirmation email setting from the GoToWebinar website. Please note that you must provide all
     * required fields including custom fields defined during the webinar creation.
     * Use the API call 'Get registration fields' to get a list of all fields, if they are required,
     * and their possible values. At this time there are two versions of the 'Create Registrant' call.
     * The first version only accepts firstName, lastName, and email and ignores all other fields.
     * If you have custom fields or want to capture additional information this version won't work for you.
     * The second version allows you to pass all required and optional fields, including custom fields
     * defined when creating the webinar. To use the second version you must pass the header
     * value 'Accept: application/vnd.citrix.g2wapi-v1.1+json' instead of 'Accept: application/json'.
     * Leaving this header out results in the first version of the API call.
     *
     * $resendConfirmation - Indicates whether the confirmation email should be resent when a registrant is re-registered. The default value is false.
     *
     */
    function createRegistrant($webinarKey, Registrant $registrantObject, $resendConfirmation = false)
    {
        ($resendConfirmation) ? $parameters = ['resendConfirmation' => true] : $parameters = ['resendConfirmation' => false];

        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/registrants', $webinarKey));

        return $this->sendAPIRequest('POST', $path, $parameters, $registrantObject);
    }


    /*
     * Removes a webinar registrant from current registrations for the specified webinar. The webinar must be a scheduled, future webinar.
     */
    function deleteRegistrant($webinarKey, $registrantKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/registrants/%s', $webinarKey, $registrantKey));

        return $this->sendAPIRequest('DELETE', $path, $parameters = null, $payload = null);
    }
}