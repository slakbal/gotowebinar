<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources;

use Carbon\CarbonImmutable;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Sessions\GetAllSessions;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Sessions\GetOrganizerSessions;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Sessions\GetSession;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Sessions\GetSessionPerformance;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Sessions\GetSessionPolls;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Sessions\GetSessionQuestions;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Sessions\GetSessionSurveys;

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

    public function performance(int $sessionKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetSessionPerformance($sessionKey, $webinarKey, $organizerKey));
    }

    public function polls(int $sessionKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetSessionPolls($sessionKey, $webinarKey, $organizerKey));
    }

    public function questions(int $sessionKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetSessionQuestions($sessionKey, $webinarKey, $organizerKey));
    }

    public function surveys(int $sessionKey, int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetSessionSurveys($sessionKey, $webinarKey, $organizerKey));
    }

    public function organizerSessions(CarbonImmutable $fromTime, CarbonImmutable $toTime, int $page = 0, int $size = 10, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetOrganizerSessions($fromTime, $toTime, $page, $size, $organizerKey));
    }
}
