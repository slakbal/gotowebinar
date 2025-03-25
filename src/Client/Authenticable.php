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

    private $directAuthenticationUrl = 'https://api.getgo.com/oauth/v2/token';
    private $authorizationUrl = 'https://authentication.logmeininc.com/oauth/authorize';

    public function authenticate()
    {
        if (! $this->hasAccessToken()) {
            if ($this->hasRefreshToken()) {
                //Get new bearer token with refresh token
                $this->refreshAccessToken();
            } else {
                //Perform fresh authentication for bearer and refresh token
//                $this->authenticateDirect();
                return $this->getAuthorizationRedirect();
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
        $response = $this->sendAuthenticationRequest([
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->getRedirectUri(),
            'client_id' => config('goto.client_id'),
        ]);

        $this->setAccessInformation($response);

        return true;
    }

    private function sendAuthenticationRequest(array $payload)
    {
        $this->response = Request::post($this->directAuthenticationUrl)
            ->strictSSL($this->strict_ssl)
            ->addHeaders($this->getAuthenticationHeader())
            ->body(http_build_query($payload), 'form')
            ->timeout($this->timeout)
            ->expectsJson()
            ->send();

        if ($this->response->code >= Response::HTTP_BAD_REQUEST) {
            throw GotoException::responseException($this->response, 'Could not authenticate with the provided credentials.', 'POST');
        }

        return $this->response->body;
    }

    private function authenticateDirect()
    {
        //I need to implementå
        $response = $this->sendAuthenticationRequest([
                                                         'grant_type' => 'password',
                                                         'username' => config('goto.direct_username'),
                                                         'password' => config('goto.direct_password'),
                                                         'client_id' => config('goto.client_id'),
                                                     ]);

        $this->setAccessInformation($response);

        return $response;
    }

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
