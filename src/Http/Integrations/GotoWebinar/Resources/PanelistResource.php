<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Panelists\CreatePanelist;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Panelists\DeletePanelist;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Panelists\GetAllPanelists;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Panelists\ResendPanelistInvitation;

class PanelistResource extends BaseResource
{
    public function all(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAllPanelists($webinarKey, $organizerKey));
    }

    public function create(array $panelistDtoArray, int $webinarKey, bool $resendConfirmation, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new CreatePanelist($panelistDtoArray, $webinarKey, $resendConfirmation, $organizerKey));
    }

    public function delete(int $webinarKey, int $panelistKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new DeletePanelist($webinarKey, $panelistKey, $organizerKey));
    }

    public function resendInvitation(int $panelistKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new ResendPanelistInvitation($panelistKey, $webinarKey, $organizerKey));
    }
}
