<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos;

class CreatePanelistDto extends BaseDto
{
    /**
     * @param string $name
     * @param string $lastName
     * @param string $email
     */
    public function __construct(
        public string $name,
        public string $email,
    ) {
        $this->name = trim($this->limit(128, $name));
        $this->email = trim($this->limit(128, $email));
    }
}
