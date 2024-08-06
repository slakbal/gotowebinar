<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar;

use Saloon\Http\Auth\AccessTokenAuthenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\HasTimeout;
use Slakbal\Gotowebinar\Exceptions\MissingAuthenticatorException;
use Slakbal\Gotowebinar\Exceptions\MissingAuthorizationException;
use Slakbal\Gotowebinar\Traits\HasResources;

class GotoApi extends Connector
{
    use AcceptsJson;
    use HasResources;
    use HasTimeout;

    protected int $connectTimeout = 10;

    protected int $requestTimeout = 30;

    public function resolveBaseUrl(): string
    {
        return 'https://api.getgo.com/G2W/rest/v2';
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        if (! cache()->has('gotoAuthorizationCode')) {
            $this->flushCache();
            throw new MissingAuthorizationException;
        }

        if (! cache()->has('gotoAuthenticator')) {
            $this->flushCache();
            throw new MissingAuthenticatorException;
        } else {
            $authenticator = cache()->get('gotoAuthenticator');
            $authenticator = AccessTokenAuthenticator::unserialize($authenticator);
        }

        //When access token is expired, refresh the access token using your refresh token and cache it
        if ($authenticator->hasExpired()) {
            $connector = new AuthConnector;
            $authenticator = $connector->refreshAccessToken($authenticator);
            cache()->forever('gotoAuthenticator', $authenticator->serialize());

            //reload the Account information also
            cache()->forget('gotoOrganizerKey');
        }

        //Load the User Account to get the Organiser ID and cache it
        if (! cache()->has('gotoOrganizerKey')) {
            $connector = new AuthConnector;
            $AccountId = $connector->getUser($authenticator)->json('id');
            cache()->forever('gotoOrganizerKey', $AccountId);
        }

        return new TokenAuthenticator($authenticator->accessToken);
    }

    public function flushCache(): bool
    {
        cache()->forget('gotoAuthorizationCode');
        cache()->forget('gotoAuthenticator');
        cache()->forget('gotoOrganizerKey');

        return true;
    }
}
