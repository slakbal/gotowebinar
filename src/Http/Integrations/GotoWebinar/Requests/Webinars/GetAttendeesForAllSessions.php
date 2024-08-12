<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars;

use Saloon\Enums\Method;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasRequestPagination;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Saloon\PaginationPlugin\Paginator;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Paginator\AttendeePaginator;

class GetAttendeesForAllSessions extends Request implements HasRequestPagination, Paginatable
{
    protected Method $method = Method::GET;

    /*
    * $webinarKey - (Required) The key of the webinar
    */
    public function __construct(
        protected int $webinarKey,
        protected int $requestPageLimit = 200, //Max default:200 - of the number of items per request when paging and collecting all the results
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
        $this->requestPageLimit = ($requestPageLimit > 200) ? 200 : $requestPageLimit;
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars/{$this->webinarKey}/attendees";
    }

    protected function defaultQuery(): array
    {
        return [
        ];
    }

    public function paginate(Connector $connector): Paginator
    {
        return new AttendeePaginator(connector: $connector, request: $this, perPageLimit: $this->requestPageLimit);
    }
}
