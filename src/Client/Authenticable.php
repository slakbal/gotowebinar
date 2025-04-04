<?php

namespace Slakbal\Gotowebinar\Client;

use Httpful\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Slakbal\Gotowebinar\Exception\GotoException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

trait Authenticable
{
    use AccessProvider;

    private $authorizationUrl = 'https://authentication.logmeininc.com/oauth/authorize';
    private $tokenUrl = 'https://authentication.logmeininc.com/oauth/token';
    private $meUrl = 'https://api.getgo.com/admin/rest/v1/me';

    public function authenticate()
    {
        if (! $this->hasAccessToken()) {

            if ($this->hasRefreshToken()) {

                //Get new bearer token with refresh token
                $this->refreshAccessToken();

            } else {

                //Perform fresh authentication for bearer and refresh token
                switch (config('goto.auth_grant_flow_type')) {
                    case 'password':
                        //Perform password grant flow authentication
                        return $this->authenticatePassword(); //returns a boolean
                        break;
                    case 'authorization':
                        //Perform authorization code flow authentication
                        return $this->getAuthorizationRedirect(); //return redirect url to redirect to
                    default:
                        throw new GotoException('Invalid authentication flow type: \''.config('goto.auth_grant_flow_type').'\'. Please check your configuration.', Response::HTTP_BAD_REQUEST);
                }

            }
        }

        return $this;
    }

    public function flushAuthentication()
    {
        $this->clearAuthCache();

        return $this;
    }

    private function refreshAccessToken()
    {
        $response = $this->sendAuthenticationRequest([
                                                         'grant_type' => 'refresh_token',
                                                         'refresh_token' => $this->getRefreshToken(),
                                                     ]);

        //explicitly set only the Access Token so that the refresh token's ttl expiry is not affected
        $this->setAccessToken($response->access_token, $response->expires_in);

        return $response;
    }

    public function getAuthorizationRedirect()
    {
        $state = Str::random(40);
        Cache::tags($this->cache_tags)->put('oauth_state', $state, Carbon::now()->addMinutes(10));

        $query = http_build_query([
            'client_id' => config('goto.client_id'),
            'redirect_uri' => $this->getRedirectUri(),
            'response_type' => 'code',
            'state' => $state,
        ]);

        return redirect($this->authorizationUrl . '?' . $query);
    }

    public function handleAuthorizationCallback($request)
    {
        $state = $request::get('state');
        $code = $request::get('code');

        // Check if state is valid
        if (!Cache::tags($this->cache_tags)->has('oauth_state') || Cache::tags($this->cache_tags)->get('oauth_state') !== $state) {
            throw new GotoException('Invalid state parameter.', Response::HTTP_BAD_REQUEST);
        }

        Cache::tags($this->cache_tags)->forget('oauth_state');

        // Exchange code for token
        $tokens = $this->sendAuthenticationRequest([
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->getRedirectUri(),
            'client_id' => config('goto.client_id'),
        ]);

        $this->setAccessInformation($tokens);

        $me = $this->getMe();
        $this->setAccountInformation($me);

        return true;
    }

    private function authenticatePassword()
    {
        $tokens = $this->sendAuthenticationRequest([
                                                        'grant_type' => 'password',
                                                        'username' => config('goto.direct_username'),
                                                        'password' => config('goto.direct_password'),
                                                        'client_id' => config('goto.client_id'),
                                                     ]);

        $this->setAccessInformation($tokens);

        $me = $this->getMe();
        $this->setAccountInformation($me);

        return true;
    }

    private function getMe()
    {
        $this->response = Request::get($this->meUrl)
            ->strictSSL($this->strict_ssl)
            ->addHeaders($this->getAuthorisationHeader())
            ->timeout($this->timeout)
            ->expectsJson()
            ->send();

        return $this->response->body;
    }

    private function sendAuthenticationRequest(array $payload)
    {
        $this->response = Request::post($this->tokenUrl)
            ->strictSSL($this->strict_ssl)
            ->addHeaders($this->getAuthenticationHeader())
            ->body(http_build_query($payload), 'form')
            ->timeout($this->timeout)
            ->expectsJson()
            ->send();

        if($this->response->code == Response::HTTP_UNAUTHORIZED)
        {
            throw GotoException::responseException($this->response, 'Could not authenticate with the provided credentials. If Password grant flow, new OAuth clients created on the Goto site will not work with a password grant flow.', 'POST');
        }

        if ($this->response->code >= Response::HTTP_BAD_REQUEST) {
            throw GotoException::responseException($this->response, 'Could not authenticate with the provided credentials.', 'POST');
        }

        return $this->response->body;
    }



    // private function setAccessInformation($response)
    // {
    //     $this->setAccessToken($response->access_token, $response->expires_in);
    //     $this->setRefreshToken($response->refresh_token, $response->expires_in);

    //     return $this;
    // }


//    private function sendAuthenticationRequest(array $payload)
//    {
//        $this->response = Request::post($this->directAuthenticationUrl)
//                                 ->strictSSL($this->strict_ssl)
//                                 ->addHeaders($this->getAuthenticationHeader())
//                                 ->body(http_build_query($payload), 'form')
//                                 ->timeout($this->timeout)
//                                 ->expectsJson()
//                                 ->send();
////        dd($this->response);
//        if ($this->response->code >= Response::HTTP_BAD_REQUEST) {
//            throw GotoException::responseException($this->response, 'Could not authenticate with the provided credentials.', 'POST');
//        }
//
//        return $this->response->body;
//    }
}
