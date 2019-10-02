<?php

namespace Slakbal\Gotowebinar\Resources\Session;

trait SessionQueryParameters
{
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
