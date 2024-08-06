<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos;

class CreateRegistrantDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public ?string $organization = null
    ) {}
}
