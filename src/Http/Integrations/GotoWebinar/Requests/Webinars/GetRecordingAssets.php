<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetRecordingAssets extends Request
{
    protected Method $method = Method::GET;

    /*
    * $webinarKey - (Required) The key of the webinar
    */
    public function __construct(
        protected int $webinarKey,
        protected int $page = 0,
        protected int $limit = 10,
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
        $this->limit = ($limit > 200) ? 200 : $limit;
    }

    public function resolveEndpoint(): string
    {
        return "/webinars/{$this->webinarKey}/recordingAssets";
    }

    protected function defaultQuery(): array
    {
        return [
            'page' => $this->page,
            'limit' => $this->limit,
        ];
    }
}
