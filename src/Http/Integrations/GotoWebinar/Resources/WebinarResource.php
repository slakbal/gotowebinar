<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Resources;

use Carbon\CarbonImmutable;
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

class WebinarResource extends BaseResource
{
    /**
     * Returns upcoming and past webinars for the currently authenticated organizer that are scheduled within the specified date/time range. Page and size parameters are optional. Default page is 0 and default size is 20. Maximum size is 200.
     * Start and End of the datetime range in ISO8601 UTC format. The reserved characters like '+' have to be encoded while being passed as query parameter.
     *
     * @param CarbonImmutable $fromTime
     * @param CarbonImmutable $toTime
     * @param int $page
     * @param int $size
     * @param int|null $organizerKey
     * @return Response
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function all(CarbonImmutable $fromTime, CarbonImmutable $toTime, int $page = 0, int $size = 10, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAllWebinars($fromTime, $toTime, $page, $size, $organizerKey));
    }

    //fromTime is optional hence it is the second optional parameter

    /**
     * Returns all insession webinars for the currently authenticated organizer that are scheduled within the specified date/time range. All inession webinars are returned in case no date/time range is provided.
     *
     * @param CarbonImmutable $toTime
     * @param CarbonImmutable|null $fromTime
     * @param int|null $organizerKey
     * @return Response
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function inSession(CarbonImmutable $toTime, ?CarbonImmutable $fromTime = null, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetInSession($toTime, $fromTime, $organizerKey));
    }

    /**
     * Retrieve information on a specific webinar. If the type of the webinar is 'sequence', a sequence of future times will be provided.
     * Webinars of type 'series' are treated the same as normal webinars - each session in the webinar series has a different webinarKey.
     * If an organizer cancels a webinar, then a request to get that webinar would return a '404 Not Found' error.
     *
     * @param int $webinarKey
     * @param int|null $organizerKey
     * @return Response
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function get(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetWebinar($webinarKey, $organizerKey));
    }

    /**
     * Retrieves the meeting times for a webinar.
     *
     * @param int $webinarKey
     * @param int|null $organizerKey
     * @return Response
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function meetingTimes(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetMeetingTimes($webinarKey, $organizerKey));
    }

    /**
     * Returns all attendees for all sessions of the specified webinar.
     *
     * @param int $webinarKey
     * @param int $page
     * @param int $size
     * @param int|null $organizerKey
     * @return Response
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function attendees(int $webinarKey, int $page = 0, int $size = 10, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAttendeesForAllSessions($webinarKey, $page, $size, $organizerKey));
    }

    /**
     * Retrieves the audio/conferencing information for a specific webinar.
     *
     * @param int $webinarKey
     * @param int|null $organizerKey
     * @return Response
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function audio(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetAudioInformation($webinarKey, $organizerKey));
    }

    /**
     * Creates a single session webinar, a sequence of webinars or a series of webinars depending on the type field in the body:
     *
     * "type": "single_session" creates a single webinar session
     * "type": "sequence" creates a webinar with multiple meeting times where attendees are expected to be the same for all sessions
     * "type": "series" creates a webinar with multiple meetings times where attendees choose only one to attend
     *
     * The default, if no type is declared, is "single_session".
     *
     * The call requires a webinar subject and description. The "isPasswordProtected" sets whether the webinar requires a password for attendees to join. If set to True, the organizer must go to Registration Settings at My Webinars (https://global.gotowebinar.com/webinars.tmpl) and add the password to the webinar, and send the password to the registrants. The response provides a numeric webinarKey in string format for the new webinar. Once a webinar has been created with this method,you can accept registrations.
     *
     * @param CreateWebinarDto $webinarDto
     * @param int|null $organizerKey
     * @return Response
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function create(CreateWebinarDto $webinarDto, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new CreateWebinar($webinarDto, $organizerKey));
    }

    /**
     * Cancels a specific webinar. If the webinar is a series or sequence, this call deletes all scheduled sessions.
     * To send cancellation emails to registrants set sendCancellationEmails=true in the request.
     * When the cancellation emails are sent, the default generated message is used in the cancellation email body.
     *
     * @param int $webinarKey
     * @param int|null $organizerKey
     * @return Response
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function cancel(int $webinarKey, bool $sendCancellationEmails = false, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new CancelWebinar($webinarKey, $sendCancellationEmails, $organizerKey));
    }

    /**
     * Gets performance details for all sessions of a specific webinar.
     *
     * @param int $webinarKey
     * @param int|null $organizerKey
     * @return Response
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function performance(int $webinarKey, ?int $organizerKey = null): Response
    {
        return $this->connector->send(new GetPerformance($webinarKey, $organizerKey));
    }

    /**
     * Retrieves a URL that can be used to start a webinar.
     * When this URL is opened in a web browser, the GoTo Webinar client will be downloaded, launched and the webinar will start after the organizer logs in with its credentials.
     *
     * @param int $webinarKey
     * @return Response
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function startUrl(int $webinarKey): Response
    {
        return $this->connector->send(new GetStartUrl($webinarKey));
    }

    /**
     * Get all the recording assets associated with online recordings of the webinarKey.
     *
     * @param int $webinarKey
     * @return Response
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function recordingAssets(int $webinarKey, int $page = 0, int $limit = 10): Response
    {
        return $this->connector->send(new GetRecordingAssets($webinarKey, $page, $limit));
    }
}
