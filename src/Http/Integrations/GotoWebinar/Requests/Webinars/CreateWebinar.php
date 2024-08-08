<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Webinars;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\CreateWebinarDto;

class CreateWebinar extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected CreateWebinarDto $webinar,
        protected ?int $organizerKey = null
    ) {
        $this->organizerKey = $organizerKey ?? cache()->get('gotoOrganizerKey');
    }

    public function resolveEndpoint(): string
    {
        return "/organizers/{$this->organizerKey}/webinars";
    }

    protected function defaultBody(): array
    {
        return [
            'subject' => $this->webinar->subject,
            'times' => [
                [
                    'startTime' => $this->webinar->startTime->toIso8601String(),
                    'endTime' => $this->webinar->endTime->toIso8601String(),
                ],
            ],
            'description' => $this->webinar->description,
            'timeZone' => $this->webinar->timeZone,
            'type' => $this->webinar->type->value, //Enum - WebinarType
            'isPasswordProtected' => $this->webinar->isPasswordProtected,
            'recordingAssetKey' => $this->webinar->recordingAssetKey,
            'isOndemand' => $this->webinar->isOndemand,
            'experienceType' => $this->webinar->experienceType->value, //Enum - WebinarExperience
            'emailSettings' => [
                'confirmationEmail' => [
                    'enabled' => $this->webinar->confirmationEmail,
                ],
                'reminderEmail' => [
                    'enabled' => $this->webinar->reminderEmail,
                ],
                'absenteeFollowUpEmail' => [
                    'enabled' => $this->webinar->absenteeFollowUpEmail,
                ],
                'attendeeFollowUpEmail' => [
                    'enabled' => ($this->webinar->attendeeIncludeCertificate) ? true : $this->webinar->attendeeFollowUpEmail,
                    'includeCertificate' => $this->webinar->attendeeIncludeCertificate,
                ],
            ],
        ];
    }
}
