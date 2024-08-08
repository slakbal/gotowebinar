<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Panelists\CreatePanelist;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Panelists\DeletePanelist;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Panelists\GetAllPanelists;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Panelists\ResendPanelistInvitation;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Registrants\GetRegistrant;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Sessions\GetAllSessions;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Sessions\GetSession;

class SessionResource extends BaseResource
{
    public function all(int $webinarKey, ?int $organizerKey = null, int $page = 0, int $limit = 100): Response
    {
        return $this->connector->send(new GetAllSessions($webinarKey, $organizerKey, $page, $limit));
    }

    public function get(int $sessionKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetSession($sessionKey, $webinarKey, $organizerKey));
    }

//    public function create(array $sessionDtoArray, int $webinarKey, bool $resendConfirmation, ?int $organizerKey = null): Response
//    {
//        return $this->connector->send(new CreateSession($sessionDtoArray, $webinarKey, $resendConfirmation, $organizerKey));
//    }
//
//    public function delete(int $webinarKey, int $sessionKey, ?int $organizerKey = null): Response
//    {
//        return $this->connector->send(new DeleteSession($webinarKey, $sessionKey, $organizerKey));
//    }
//
//    public function resendInvitation(int $sessionKey, int $webinarKey, ?int $organizerKey = null): Response
//    {
//        return $this->connector->send(new ResendSessionInvitation($sessionKey, $webinarKey, $organizerKey));
//    }
}
