<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Sessions;

use Carbon\CarbonImmutable;
use Saloon\Enums\Method;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasRequestPagination;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Saloon\PaginationPlugin\Paginator;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Paginator\SessionPaginator;

class GetOrganizerSessions extends Request implements HasRequestPagination, Paginatable
{
    protected Method $method = Method::GET;

    public function __construct(
        protected CarbonImmutable $fromTime,
        protected CarbonImmutable $toTime,
        protected int $requestPageLimit = 200, //Max default:200 - of the number of items per request when paging and collecting all the results
        protected ?int $organizerKey = null,
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
        $this->requestPageLimit = ($requestPageLimit > 200) ? 200 : $requestPageLimit;
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/sessions";
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
        return new SessionPaginator(connector: $connector, request: $this, perPageLimit: $this->requestPageLimit);
    }
}
