<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Registrants;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAllRegistrants extends Request
{
    protected Method $method = Method::GET;

    /*
    * $webinarKey - (Required) The key of the webinar
    */
    public function __construct(
        protected int $webinarKey,
        protected ?int $organizerKey,
        protected ?int $page = null,
        protected ?int $pageSize = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
        $this->pageSize = ($pageSize > 200) ? 200 : $pageSize;
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars/{$this->webinarKey}/registrants";
    }

    protected function defaultQuery(): array
    {
        $query = [];

        if (! is_null($this->page)) {
            $query['page'] = $this->page;
        }

        if (! is_null($this->pageSize)) {
            $query['limit'] = $this->pageSize;
        }

        return $query;
    }
}
