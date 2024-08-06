<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Requests\Account;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\Account;

class GetAccount extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'https://api.getgo.com/identity/v1/Users/me';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json();

        return new Account(
            id: $data['id'],
            userName: $data['userName'],
            displayName: $data['displayName'],
            locale: $data['locale'],
            timezone: $data['timezone'],
            title: $data['title'],
        );
    }
}
