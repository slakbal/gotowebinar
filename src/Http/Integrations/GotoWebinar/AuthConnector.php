<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar;

use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Http\OAuth2\GetAccessTokenRequest;
use Saloon\Http\OAuth2\GetRefreshTokenRequest;
use Saloon\Http\OAuth2\GetUserRequest;
use Saloon\Http\Request;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;
use Saloon\Traits\Plugins\AcceptsJson;

class AuthConnector extends Connector
{
    use AcceptsJson;
    use AuthorizationCodeGrant;

    /**
     * The Base URL of the API.
     */
    public function resolveBaseUrl(): string
    {
        return '';
    }

    /**
     * The OAuth2 configuration
     */
    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId(config('gotowebinar.client_id'))
            ->setClientSecret(config('gotowebinar.client_secret'))
            ->setRedirectUri(url()->route('goto.callback'))
            ->setDefaultScopes(['collab:'])
            ->setAuthorizeEndpoint('https://authentication.logmeininc.com/oauth/authorize')
            ->setTokenEndpoint('https://authentication.logmeininc.com/oauth/token')
            ->setUserEndpoint('https://api.getgo.com/identity/v1/Users/me')
            ->setRequestModifier(function (Request $request) {
                $request->headers()->merge([
                    'Authorization' => 'Basic '.base64_encode(sprintf('%s:%s', config('gotowebinar.client_id'), config('gotowebinar.client_secret'))),
                ]);
            });

        //        return OAuthConfig::make()
        //            ->setClientId(config('gotowebinar.client_id'))
        //            ->setClientSecret(config('gotowebinar.client_secret'))
        //            ->setRedirectUri(url()->route('goto.callback'))
        //            ->setDefaultScopes([])
        //            ->setAuthorizeEndpoint('https://authentication.logmeininc.com/oauth/authorize')
        //            ->setTokenEndpoint('https://authentication.logmeininc.com/oauth/token')
        //            ->setUserEndpoint('/me');
        //            ->setRequestModifier(function (Request $request) {
        //                // Optional: Modify the requests being sent.
        ////                $request->headers()->merge([
        ////
        ////                ]);
        //                $request->query()->merge([
        //                   'x' => 'y'
        //                ]);
        //            });
        //        ->setRequestModifier(function (Request $request) {
        //            // This callback is invoked on every request, so you
        //            // may want to use if-statements or a match statement
        //            // to apply conditions based on request.
        //
        //            if ($request instanceof GetAccessTokenRequest) {
        //                $request->query()->add('access_type', 'offline');
        //            }
        //
        //            if ($request instanceof GetRefreshTokenRequest) {
        //                $request->headers()->add('X-App-Key', $appKey);
        //            }
        //
        //            if ($request instanceof GetUserRequest) {
        //                $request->headers('Accept', 'text/plain');
        //            }
        //        });
    }
}
