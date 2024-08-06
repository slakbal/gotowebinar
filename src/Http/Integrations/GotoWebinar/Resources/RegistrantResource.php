<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Registrants\GetAllRegistrants;

class RegistrantResource extends BaseResource
{
    public function all(int $webinarKey, ?int $organizerKey = null, int $page = 0, int $limit = 100): Response
    {
        return $this->connector->send(new GetAllRegistrants($webinarKey, $organizerKey, $page, $limit));
    }
}
