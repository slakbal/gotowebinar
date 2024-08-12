<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars;

use Carbon\CarbonImmutable;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class GetWebinarsByPage extends Request implements Paginatable
{
    protected Method $method = Method::GET;

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
        protected int $pageSize = 10,
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
        $this->pageSize = ($pageSize > 200) ? 200 : $pageSize;
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
            'page' => $this->page,
            'size' => $this->pageSize,
        ];
    }
}
