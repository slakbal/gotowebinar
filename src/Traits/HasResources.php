<?php

namespace Slakbal\Gotowebinar\Traits;

use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources\AccountResource;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources\WebinarResource;

trait HasResources
{
    public function account(): AccountResource
    {
        return new AccountResource($this);
    }

    public function webinars(): WebinarResource
    {
        return new WebinarResource($this);
    }
}
