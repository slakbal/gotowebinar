<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Panelists;

use Illuminate\Support\Arr;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\CreatePanelistDto;

class CreatePanelist extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array $panelistDtoArray,
        protected int $webinarKey,
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars/{$this->webinarKey}/panelists";
    }

    protected function defaultBody(): array
    {
        if(count($this->panelistDtoArray) === 0){
            return [];
        }

        return Arr::map($this->panelistDtoArray, function (CreatePanelistDto $panelistDto) {
            return [
                'name' => $panelistDto->name,
                'email' => $panelistDto->email,
            ];
        });
    }
}
