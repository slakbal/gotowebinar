<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars;

use Carbon\CarbonImmutable;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetInSession extends Request
{
    protected Method $method = Method::GET;

    /*
    * $fromTime - (Required) Start of the datetime range in ISO8601 UTC format. The reserved characters like '+' have to be encoded while being passed as query parameter.
    * toTime - (Required) End of the datetime range in ISO8601 UTC format. The reserved characters like '+' have to be encoded while being passed as query parameter.
    */
    public function __construct(
        protected CarbonImmutable $toTime,
        protected ?CarbonImmutable $fromTime = null,
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = cache()->get('gotoOrganizerKey');
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/insessionWebinars";
    }

    protected function defaultQuery(): array
    {
        $queries = ['toTime' => $this->toTime->endOfDay()->setTimezone('UTC')->toIso8601String()];

        if (! empty($this->fromTime)) {
            $queries = array_merge($queries, ['fromTime' => $this->fromTime->startOfDay()->setTimezone('UTC')->toIso8601String()]);
        }

        return $queries;
    }
}
