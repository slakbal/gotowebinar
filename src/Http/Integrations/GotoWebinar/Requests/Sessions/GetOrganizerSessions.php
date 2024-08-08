<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Sessions;

use Carbon\CarbonImmutable;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetOrganizerSessions extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected CarbonImmutable $fromTime,
        protected CarbonImmutable $toTime,
        protected int $page = 0,
        protected int $size = 10,
        protected ?int $organizerKey = null,
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
        $this->size = ($size > 200) ? 200 : $size;
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/sessions";
    }

    protected function defaultQuery(): array
    {
        return [
            'fromTime' => $this->fromTime->setTimezone('UTC')->toIso8601String(),
            'toTime' => $this->toTime->setTimezone('UTC')->toIso8601String(),
            'page' => $this->page,
            'size' => $this->size,
        ];
    }
}
