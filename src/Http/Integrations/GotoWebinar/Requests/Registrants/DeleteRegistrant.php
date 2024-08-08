<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Registrants;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteRegistrant extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected int $webinarKey,
        protected int $registrantKey,
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars/{$this->webinarKey}/registrants/{$this->registrantKey}";
    }
}
