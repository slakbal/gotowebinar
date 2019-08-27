<?php

namespace Slakbal\Gotowebinar\Traits\Client;

use Illuminate\Support\Str;

trait Authenticable
{
    use AccessProvider;


    public function status()
    {
        return [
            'ready' => $this->hasAccessToken(),
            'access_token' => Str::limit($this->getAccessToken(), 10),
            'refresh_token' => Str::limit($this->getRefreshToken(), 10),
            'organiser_key' => Str::limit($this->getOrganizerKey(), 8),
            'account_key' => Str::limit($this->getAccountKey(), 8),
        ];
    }


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


    public function flushAuthentication()
    {
        $this->clearAuthCache();

        return $this;
    }

}