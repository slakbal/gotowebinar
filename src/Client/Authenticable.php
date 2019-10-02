<?php

namespace Slakbal\Gotowebinar\Client;

use Httpful\Request;
use Illuminate\Http\Response;
use Slakbal\Gotowebinar\Exception\GotoException;

trait Authenticable
{
    use AccessProvider;

    private $directAuthenticationUrl = 'https://api.getgo.com/oauth/v2/token';

    public function authenticate()
    {
        if (! $this->hasAccessToken()) {
            if ($this->hasRefreshToken()) {
                //Get new bearer token with refresh token
                $this->refreshAccessToken();
            } else {
                //Perform fresh authentication for bearer and refresh token
                $this->authenticateDirect();
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

    private function authenticateDirect()
    {
        $response = $this->sendAuthenticationRequest([
                                                         'grant_type' => 'password',
                                                         'username' => config('goto.direct_username'),
                                                         'password' => config('goto.direct_password'),
                                                         'client_id' => config('goto.client_id'),
                                                     ]);

        $this->setAccessInformation($response);

        return $response;
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
}
