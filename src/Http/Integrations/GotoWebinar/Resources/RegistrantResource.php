<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\CreateRegistrantDto;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Registrants\CreateRegistrant;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Registrants\DeleteRegistrant;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Registrants\GetAllRegistrants;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Registrants\GetRegistrant;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Registrants\GetRegistrationFields;

class RegistrantResource extends BaseResource
{
    public function all(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAllRegistrants($webinarKey, $organizerKey));
    }

    public function page(int $webinarKey, ?int $page = 0, ?int $pageSize = 100, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAllRegistrants($webinarKey, $organizerKey, $page, $pageSize));
    }

    public function get(int $registrantKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetRegistrant($registrantKey, $webinarKey, $organizerKey));
    }

    public function create(CreateRegistrantDto $registrantDto, int $webinarKey, bool $resendConfirmation, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new CreateRegistrant($registrantDto, $webinarKey, $resendConfirmation, $organizerKey));
    }

    public function delete(int $webinarKey, int $registrantKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new DeleteRegistrant($webinarKey, $registrantKey, $organizerKey));
    }

    public function fields(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetRegistrationFields($webinarKey, $organizerKey));
    }
}
