<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos;

use Carbon\CarbonImmutable;
use Illuminate\Support\Str;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Enums\WebinarExperience;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Enums\WebinarType;

class CreateWebinarDto extends BaseDto
{
    /**
     * @param string $subject
     * @param CarbonImmutable $startTime
     * @param CarbonImmutable $endTime
     * @param string $description
     * @param string|null $timeZone
     * @param WebinarType $type
     * @param bool $isPasswordProtected
     * @param string|null $recordingAssetKey
     * @param bool $isOndemand
     * @param WebinarExperience $experienceType
     * @param bool $confirmationEmail
     * @param bool $reminderEmail
     * @param bool $absenteeFollowUpEmail
     * @param bool $attendeeFollowUpEmail
     * @param bool $attendeeIncludeCertificate
     * @param string|null $suffix
     */
    public function __construct(
        public string $subject,
        public CarbonImmutable $startTime,
        public CarbonImmutable $endTime,
        public string $description,
        public ?string $timeZone = null,
        public WebinarType $type = WebinarType::SINGLE_SESSION,
        public bool $isPasswordProtected = false,
        public ?string $recordingAssetKey = null,
        public bool $isOndemand = false,
        public WebinarExperience $experienceType = WebinarExperience::CLASSIC,
        public bool $confirmationEmail = false,
        public bool $reminderEmail = false,
        public bool $absenteeFollowUpEmail = false,
        public bool $attendeeFollowUpEmail = false,
        public bool $attendeeIncludeCertificate = false,
        public ?string $suffix = null
    ) {
        $this->subject = trim($this->limit(128, $subject, $suffix));
        $this->description = trim($this->limit(2048, $description));
        $this->timeZone = $timeZone ?? now()->timezone->getName();
    }

}
