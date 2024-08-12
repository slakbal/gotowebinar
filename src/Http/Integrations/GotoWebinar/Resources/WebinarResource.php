<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources;

use Carbon\CarbonImmutable;
use Illuminate\Support\LazyCollection;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\CreateWebinarDto;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\CancelWebinar;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\CreateWebinar;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\GetAllWebinars;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\GetAttendeesForAllSessions;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\GetAudioInformation;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\GetInSession;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\GetMeetingTimes;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\GetPerformance;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\GetRecordingAssets;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\GetStartUrl;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\GetWebinar;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars\GetWebinarsByPage;

class WebinarResource extends BaseResource
{
    public function all(CarbonImmutable $fromTime, CarbonImmutable $toTime, ?int $requestPageLimit = 200, ?int $organizerKey = null): LazyCollection
    {
        $paginator = (new GetAllWebinars($fromTime, $toTime, $requestPageLimit, $organizerKey))->paginate($this->connector);

        return $paginator->collect();
    }

    public function page(CarbonImmutable $fromTime, CarbonImmutable $toTime, int $page = 0, int $pageSize = 100, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetWebinarsByPage($fromTime, $toTime, $page, $pageSize, $organizerKey));
    }

    public function inSession(CarbonImmutable $toTime, ?CarbonImmutable $fromTime = null, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetInSession($toTime, $fromTime, $organizerKey));
    }

    public function get(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetWebinar($webinarKey, $organizerKey));
    }

    public function meetingTimes(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetMeetingTimes($webinarKey, $organizerKey));
    }

    public function attendees(int $webinarKey, ?int $requestPageLimit = 200, ?int $organizerKey = null): LazyCollection
    {
        $paginator = (new GetAttendeesForAllSessions($webinarKey, $requestPageLimit, $organizerKey))->paginate($this->connector);

        return $paginator->collect();
    }

    public function audio(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAudioInformation($webinarKey, $organizerKey));
    }

    public function create(CreateWebinarDto $webinarDto, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new CreateWebinar($webinarDto, $organizerKey));
    }

    public function cancel(int $webinarKey, bool $sendCancellationEmails = false, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new CancelWebinar($webinarKey, $sendCancellationEmails, $organizerKey));
    }

    public function performance(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetPerformance($webinarKey, $organizerKey));
    }

    public function startUrl(int $webinarKey): Response
    {
        return $this->connector->send(new GetStartUrl($webinarKey));
    }

    public function recordingAssets(int $webinarKey, ?int $page = 0, ?int $pageSize = 100): Response
    {
        return $this->connector->send(new GetRecordingAssets($webinarKey, $page, $pageSize));
    }
}
