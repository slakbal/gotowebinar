<?php

namespace Slakbal\Gotowebinar\Resources\Webinar;

use Carbon\Carbon;

trait WebinarQueryParameters
{
    public function fromTime(Carbon $value): self
    {
        $this->queryParameters['fromTime'] = $value->toW3cString();

        return $this;
    }

    public function toTime(Carbon $value): self
    {
        $this->queryParameters['toTime'] = $value->toW3cString();

        return $this;
    }

    public function page($value): self
    {
        $this->queryParameters['page'] = $value;

        return $this;
    }

    public function size($value): self
    {
        $this->queryParameters['size'] = $value;

        return $this;
    }

    public function sendUpdateNotifications(): self
    {
        $this->queryParameters['notifyParticipants'] = true;

        return $this;
    }

    public function dontSendUpdateNotifications(): self
    {
        $this->queryParameters['notifyParticipants'] = false;

        return $this;
    }

    public function sendCancellationEmails(): self
    {
        $this->queryParameters['sendCancellationEmails'] = true;

        return $this;
    }

    public function dontSendCancellationEmails(): self
    {
        $this->queryParameters['sendCancellationEmails'] = false;

        return $this;
    }
}
