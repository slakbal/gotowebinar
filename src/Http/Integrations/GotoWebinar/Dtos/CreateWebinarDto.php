<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos;

use Carbon\CarbonImmutable;
use Illuminate\Support\Str;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Enums\WebinarExperience;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Enums\WebinarType;

class CreateWebinarDto
{
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
        $this->subject = $this->getSubject($subject, $suffix);
        $this->description = Str::limit($this->description, 2048 - 3);
        $this->timeZone = $timeZone ?? now()->timezone->getName();
    }

    private function getSubject(string $subject, ?string $suffix = null): string
    {
        $maxLength = (128 - 3);

        if (! empty($suffix)) {
            $suffix_length = Str::length($suffix);
            $subject_length = Str::length($subject);

            if (($suffix_length + $subject_length) > $maxLength) {
                return Str::limit($subject, (128 - ($suffix_length + 3)), $suffix.'...');
            }

            return $subject.$suffix;

        } else {
            return Str::limit($subject, $maxLength);
        }
    }
}
