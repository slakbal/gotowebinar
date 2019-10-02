<?php

namespace Slakbal\Gotowebinar\Resources\Session;

use Carbon\Carbon;

trait SessionQueryParameters
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
}
