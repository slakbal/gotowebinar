<?php

namespace Slakbal\Gotowebinar\Traits;

use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources\AccountResource;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources\PanelistResource;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources\RegistrantResource;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources\SessionResource;
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

    public function registrants(): RegistrantResource
    {
        return new RegistrantResource($this);
    }

    public function panelists(): PanelistResource
    {
        return new PanelistResource($this);
    }

    public function sessions(): SessionResource
    {
        return new SessionResource($this);
    }
}
