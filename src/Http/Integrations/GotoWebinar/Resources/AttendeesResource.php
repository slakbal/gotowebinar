<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Attendees\GetAllAttendees;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Attendees\GetAttendee;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Attendees\GetAttendeePolls;

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

    public function polls(int $sessionKey, int $registrantKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAttendeePolls($sessionKey, $registrantKey, $webinarKey, $organizerKey));
    }

//    public function performance(int $attendeeKey, int $webinarKey, ?int $organizerKey = null): Response
//    {
//        return $this->connector->send(new GetAttendeePerformance($attendeeKey, $webinarKey, $organizerKey));
//    }
//
//    public function polls(int $attendeeKey, int $webinarKey, ?int $organizerKey = null): Response
//    {
//        return $this->connector->send(new GetAttendeePolls($attendeeKey, $webinarKey, $organizerKey));
//    }
//
//    public function questions(int $attendeeKey, int $webinarKey, ?int $organizerKey = null): Response
//    {
//        return $this->connector->send(new GetAttendeeQuestions($attendeeKey, $webinarKey, $organizerKey));
//    }
//
//    public function surveys(int $attendeeKey, int $webinarKey, ?int $organizerKey = null): Response
//    {
//        return $this->connector->send(new GetAttendeeSurveys($attendeeKey, $webinarKey, $organizerKey));
//    }
//
//    public function organizerAttendees(CarbonImmutable $fromTime, CarbonImmutable $toTime, int $page = 0, int $size = 10, ?int $organizerKey = null): Response
//    {
//        return $this->connector->send(new GetOrganizerAttendees($fromTime, $toTime, $page, $size, $organizerKey));
//    }
}
