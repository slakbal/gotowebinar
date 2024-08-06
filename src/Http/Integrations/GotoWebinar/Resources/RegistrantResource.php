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
    public function all(int $webinarKey, ?int $organizerKey = null, int $page = 0, int $limit = 100): Response
    {
        return $this->connector->send(new GetAllRegistrants($webinarKey, $organizerKey, $page, $limit));
    }

    public function get(int $registrantKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetRegistrant($registrantKey, $webinarKey, $organizerKey));
    }

    public function create(CreateRegistrantDto $registrantDto, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new CreateRegistrant($registrantDto, $webinarKey, $organizerKey));
    }

    //    public function delete($webinarDto, ?int $organizerKey = null): Response
    //    {
    //        return $this->connector->send(new DeleteRegistrant($webinarDto, $organizerKey));
    //    }
    //
    //    public function fields($webinarDto, ?int $organizerKey = null): Response
    //    {
    //        return $this->connector->send(new GetRegistrationFields($webinarDto, $organizerKey));
    //    }
}
