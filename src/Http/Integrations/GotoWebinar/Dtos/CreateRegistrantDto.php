<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos;

class CreateRegistrantDto extends BaseDto
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string|null $organization
     */
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public ?string $organization = null
    ) {
        $this->firstName = trim($this->limit(128, $firstName));
        $this->lastName = trim($this->limit(128, $lastName));
        $this->email = trim($this->limit(128, $email));
        $this->organization = trim($this->limit(128, $organization));
    }
}
