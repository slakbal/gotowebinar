<?php

namespace Slakbal\Gotowebinar\Traits\Webinar;

trait WebinarOperations
{
    /*
     * Returns upcoming and past webinars for the currently authenticated organizer
     * that are scheduled within the specified date/time range. Page and size parameters are optional.
     * Default page is 0 and default size is 20.
     */
    public function getWebinars($parameters = null)
    {
        $path = $this->getPathRelativeToOrganizer('webinars');

        return $this->sendAPIRequest('GET', $path, $parameters);
    }


}