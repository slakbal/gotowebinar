<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Registrants;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\CreateRegistrantDto;

class CreateRegistrant extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected CreateRegistrantDto $registrant,
        protected int $webinarKey,
        protected bool $resendConfirmation = false,
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars/{$this->webinarKey}/registrants";
    }

    protected function defaultBody(): array
    {
        return [
            'firstName' => $this->registrant->firstName,
            'lastName' => $this->registrant->lastName,
            'email' => $this->registrant->email,
            'organization' => $this->registrant->organization,
        ];
    }

    /*
     * Set to 'application/json' to make a registration using fields (custom or default) additional to the basic ones or
     * set it to 'application/vnd.citrix.g2wapi-v1.1+json' for just basic fields(firstName, lastName, and email).
     */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/vnd.citrix.g2wapi-v1.1+json',
        ];
    }

    protected function defaultQuery(): array
    {
        //Indicates whether the confirmation email should be resent when a registrant is re-registered. The default value is false.
        return ['resendConfirmation' => $this->sendCancellationEmails];
    }
}
