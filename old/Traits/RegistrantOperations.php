<?php

namespace Slakbal\Gotowebinar\Old\Traits;

use Slakbal\Gotowebinar\Old\Entity\Registrant;

trait RegistrantOperations
{

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

        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/registrants', $webinarKey));

        $attendeeObject = new Registrant($payloadArray);

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
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/registrants', $webinarKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Retrieve registration details for a specific registrant.
     */
    function getRegistrant($webinarKey, $registrantKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/registrants/%s', $webinarKey, $registrantKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Removes a webinar registrant from current registrations for the specified webinar. The webinar must be a scheduled, future webinar.
     */
    function deleteRegistrant($webinarKey, $registrantKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/registrants/%s', $webinarKey, $registrantKey));

        return $this->sendRequest('DELETE', $path, $parameters = null, $payload = null);
    }
}