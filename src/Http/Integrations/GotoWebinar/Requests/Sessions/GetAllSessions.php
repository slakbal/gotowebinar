<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Sessions;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAllSessions extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected int $webinarKey,
        protected ?int $organizerKey = null,
        protected int $page = 0,
        protected int $size = 10,
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
        $this->size = ($size > 200) ? 200 : $size;
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars/{$this->webinarKey}/sessions";
    }

    protected function defaultQuery(): array
    {
        return [
            'page' => $this->page,
            'size' => $this->size,
        ];
    }
}
