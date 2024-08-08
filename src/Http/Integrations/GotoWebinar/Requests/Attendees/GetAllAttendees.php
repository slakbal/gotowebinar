<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Attendees;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAllAttendees extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected int $sessionKey,
        protected int $webinarKey,
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars/{$this->webinarKey}/sessions/{$this->sessionKey}/attendees";
    }
}
