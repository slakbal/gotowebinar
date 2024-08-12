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
        protected ?int $page = null,
        protected ?int $pageSize = null,
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
        $this->pageSize = ($pageSize > 200) ? 200 : $pageSize;
    }

    public function resolveEndpoint(): string
    {
        return "/webinars/{$this->webinarKey}/recordingAssets";
    }

    protected function defaultQuery(): array
    {
        $query = [];

        if (! is_null($this->page)) {
            $query['page'] = $this->page;
        }

        if (! is_null($this->pageSize)) {
            $query['limit'] = $this->pageSize;
        }

        return $query;
    }
}
