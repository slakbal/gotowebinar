<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources;

use Carbon\CarbonImmutable;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\CreateWebinarDto;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\CancelWebinar;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\CreateWebinar;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\GetAllWebinars;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\GetWebinar;

class WebinarResource extends BaseResource
{
    /*
    * $fromTime - (Required) Start of the datetime range in ISO8601 UTC format. The reserved characters like '+' have to be encoded while being passed as query parameter.
    * toTime - (Required) End of the datetime range in ISO8601 UTC format. The reserved characters like '+' have to be encoded while being passed as query parameter.
    * page - The page number to be displayed. The first page is 0.
    * size - The size of the page.
    */
    public function all(CarbonImmutable $fromTime, CarbonImmutable $toTime, int $page = 0, int $size = 10): Response
    {
        return $this->connector->send(new GetAllWebinars($fromTime, $toTime, $page, $size));
    }

    public function get(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetWebinar($webinarKey, $organizerKey));
    }

    public function create(CreateWebinarDto $webinarDto): Response
    {
        return $this->connector->send(new CreateWebinar($webinarDto));
    }

    public function cancel(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new CancelWebinar($webinarKey, $organizerKey));
    }
}
