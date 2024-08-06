<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars;

use Carbon\CarbonImmutable;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAllWebinars extends Request
{
    protected Method $method = Method::GET;

    protected $organizerKey;

    /*
    * $fromTime - (Required) Start of the datetime range in ISO8601 UTC format. The reserved characters like '+' have to be encoded while being passed as query parameter.
    * toTime - (Required) End of the datetime range in ISO8601 UTC format. The reserved characters like '+' have to be encoded while being passed as query parameter.
    * page - The page number to be displayed. The first page is 0.
    * size - The size of the page.
    */
    public function __construct(
        protected CarbonImmutable $fromTime,
        protected CarbonImmutable $toTime,
        protected int $page = 0,
        protected int $size = 10
    ) {
        $this->organizerKey = cache()->get('gotoOrganizerKey');
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars";
    }

    protected function defaultQuery(): array
    {
        return [
            'fromTime' => $this->fromTime->startOfDay()->setTimezone('UTC')->toIso8601String(),
            'toTime' => $this->toTime->endOfDay()->setTimezone('UTC')->toIso8601String(),
            'page' => $this->page,
            'size' => $this->size,
        ];
    }
}
