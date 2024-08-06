<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetWebinar extends Request
{
    protected Method $method = Method::GET;

    protected $organizerKey;

    protected int $webinarKey;

    /*
    * $webinarKey - (Required) The key of the webinar
    */
    public function __construct(
        int $webinarKey,
        ?int $organizerKey = null
    ) {
        $this->webinarKey = $webinarKey;
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars/{$this->webinarKey}";
    }

    protected function defaultQuery(): array
    {
        return [];
    }
}
