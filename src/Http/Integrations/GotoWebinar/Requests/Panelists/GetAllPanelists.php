<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Panelists;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAllPanelists extends Request
{
    protected Method $method = Method::GET;

    /*
    * $webinarKey - (Required) The key of the webinar
    */
    public function __construct(
        protected int $webinarKey,
        protected ?int $organizerKey
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars/{$this->webinarKey}/panelists";
    }
}
