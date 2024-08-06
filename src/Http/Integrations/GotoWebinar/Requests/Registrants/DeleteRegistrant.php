<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Registrants;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteRegistrant extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected int $webinarKey,
        protected bool $sendCancellationEmails = false,
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars/{$this->webinarKey}";
    }

    protected function defaultQuery(): array
    {
        return ['sendCancellationEmails' => $this->sendCancellationEmails];
    }
}
