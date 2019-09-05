<?php

namespace Slakbal\Gotowebinar;

trait RegistrantQueryParameters
{
    /*
     * Indicates whether the confirmation email should be resent when a registrant is re-registered.
     *
     * The default value is false.
     */
    public function resendConfirmation(): self
    {
        $this->queryParameters['resendConfirmation'] = true;

        return $this;
    }
}
