<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Traits\Responses\HasResponse;

class Account implements WithResponse
{
    use HasResponse;

    public function __construct(
        public readonly int $id,
        public readonly string $userName,
        public readonly string $displayName,
        public readonly string $locale,
        public readonly string $timezone,
        public readonly string $title,
    ) {}
}
