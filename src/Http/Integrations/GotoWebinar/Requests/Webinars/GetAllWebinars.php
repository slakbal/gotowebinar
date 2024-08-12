<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars;

use Carbon\CarbonImmutable;
use Saloon\Enums\Method;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasRequestPagination;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Saloon\PaginationPlugin\Paginator;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Paginator\WebinarPaginator;

class GetAllWebinars extends Request implements HasRequestPagination, Paginatable
{
    protected Method $method = Method::GET;

    /*
    * $fromTime - (Required) Start of the datetime range in ISO8601 UTC format. The reserved characters like '+' have to be encoded while being passed as query parameter.
    * toTime - (Required) End of the datetime range in ISO8601 UTC format. The reserved characters like '+' have to be encoded while being passed as query parameter.
    */
    public function __construct(
        protected CarbonImmutable $fromTime,
        protected CarbonImmutable $toTime,
        protected int $requestPageLimit = 200, //Max default:200 - of the number of items per request when paging and collecting all the results
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
        $this->requestPageLimit = ($requestPageLimit > 200) ? 200 : $requestPageLimit;
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars";
    }

    protected function defaultQuery(): array
    {
        return [
            'fromTime' => $this->fromTime->setTimezone('UTC')->toIso8601String(),
            'toTime' => $this->toTime->setTimezone('UTC')->toIso8601String(),
        ];
    }

    public function paginate(Connector $connector): Paginator
    {
        return new WebinarPaginator(connector: $connector, request: $this, perPageLimit: $this->requestPageLimit);
    }
}
