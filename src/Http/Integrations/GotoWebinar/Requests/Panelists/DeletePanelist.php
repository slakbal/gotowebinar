<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Panelists;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeletePanelist extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected int $webinarKey,
        protected int $panelistKey,
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars/{$this->webinarKey}/panelists/{$this->panelistKey}";
    }
}
