<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Attendees\GetAllAttendees;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Attendees\GetAttendee;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Attendees\GetAttendeePollAnswers;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Attendees\GetAttendeeQuestions;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Attendees\GetAttendeeSurveys;

class AttendeesResource extends BaseResource
{
    public function all(int $sessionKey,int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAllAttendees($sessionKey, $webinarKey, $organizerKey));
    }

    public function get(int $sessionKey, int $registrantKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAttendee($sessionKey, $registrantKey, $webinarKey, $organizerKey));
    }

    public function pollAnswers(int $sessionKey, int $registrantKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAttendeePollAnswers($sessionKey, $registrantKey, $webinarKey, $organizerKey));
    }

    public function questions(int $sessionKey, int $registrantKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAttendeeQuestions($sessionKey, $registrantKey, $webinarKey, $organizerKey));
    }

    public function surveys(int $sessionKey, int $registrantKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAttendeeSurveys($sessionKey, $registrantKey, $webinarKey, $organizerKey));
    }

}
