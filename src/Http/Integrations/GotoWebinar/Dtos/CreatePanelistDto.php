<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos;

class CreatePanelistDto extends BaseDto
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     */
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
    ) {
        $this->firstName = trim($this->limit(128, $firstName));
        $this->lastName = trim($this->limit(128, $lastName));
        $this->email = trim($this->limit(128, $email));
    }
}
