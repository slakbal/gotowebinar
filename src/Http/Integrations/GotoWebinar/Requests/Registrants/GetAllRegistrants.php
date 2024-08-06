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
        protected ?int $page,
        protected int $limit = 100
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars/{$this->webinarKey}/registrants";
    }

    protected function defaultQuery(): array
    {
        return [
            'page' => $this->page,
            'limit' => $this->limit,
        ];
    }
}
