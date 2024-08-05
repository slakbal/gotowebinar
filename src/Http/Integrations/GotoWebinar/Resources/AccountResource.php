<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\GetAccount;

class AccountResource extends BaseResource
{
    public function getAccount(): Response
    {
        return $this->connector->send(new GetAccount);
    }
}
