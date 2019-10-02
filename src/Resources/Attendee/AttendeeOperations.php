<?php

namespace Slakbal\Gotowebinar\Resources\Attendee;

trait AttendeeOperations
{
    public function webinarKey($webinarKey): self
    {
        $this->pathKeys['webinarKey'] = $webinarKey;

        return $this;
    }
}
