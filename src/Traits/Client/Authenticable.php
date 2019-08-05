<?php

namespace Slakbal\Gotowebinar\Traits\Client;

use Httpful\Request;

trait Authenticable
{
    use AccessProvider;


    public function checkAuthentication()
    {
        if (! $this->hasAccessToken()) {
            $this->authenticate();
        }

        return $this;
    }


    public function authenticate()
    {
        return $this->authenticateDirect();
    }


    private function authenticateDirect()
    {
        try {

            $payload = [
                'grant_type' => 'password',
                'username' => config('goto.direct_username'),
                'password' => config('goto.direct_password'),
                'client_id' => config('goto.client_id'),
            ];

            $this->response = Request::post($this->getPath(self::BASE_URI, 'oauth/v2/token'))
                                     ->strictSSL($this->strict_ssl)
                                     ->addHeaders($this->getAuthenticationHeader())
                                     ->body(http_build_query($payload), 'form')
                                     ->timeout($this->timeout)
                                     ->expectsJson()
                                     ->send();

            $this->setAccessInformation($this->response->body);
        } catch (\Exception $e) {

            dd($e->getMessage());

            $this->throwResponseException('POST', $this->response, $e->getMessage());
        }
        //the authObject is in the body of the response object
        return $this->response->body;
    }


    public function refreshAuthentication()
    {
        $this->clearAuthCache();

        $this->authenticate();

        return $this;
    }


    public function getAuthorizationCode()
    {
        try {

            $parameters = [
                'response_type' => 'code',
                'client_id' => $this->getClientId(),
                'client_secret' => $this->getClientSecret(),
                'state' => csrf_token(),
                'redirect_uri' => route('goto.redirect'),
            ];

//            dump($this->getPath(self::BASE_URI, 'oauth/v2/authorize', $parameters));

            $this->response = Request::get($this->getPath(self::BASE_URI, 'oauth/v2/authorize', $parameters))
                                     ->addHeaders($this->getAuthenticationHeader())
                                     ->strictSSL($this->strict_ssl)
                                     ->timeout($this->timeout)
                                     ->send();

            //dd($this->response);
        } catch (\Exception $e) {

            $this->throwResponseException('POST', $this->response, $e->getMessage());
        }
        //the authObject is in the body of the response object
        return $this->response;
    }

    /*

            public function getAccessToken()
            {
                try {
                    $this->response = Request::post($this->getPath(self::AUTH_ENDPOINT, 'token'))
                                             ->strictSSL($this->strict_ssl)
                                             ->addHeaders($this->getAuthHeaders())
                                             ->timeout($this->timeout)
                                             ->body('grant_type=authorization_code&code=' . config('goto.response_key'), 'form')
                                             ->expectsJson()
                                             ->send();

                    dd($this->response);
                } catch (\Exception $e) {
                    $this->throwResponseException('POST', $this->response, $e->getMessage());
                }
                //the authObject is in the body of the response object
                return $this->response->body;
            }


            public function refreshTokens()
            {
                try {

                    $this->response = Request::post($this->getPath(self::AUTH_ENDPOINT, 'token'))
                                             ->strictSSL($this->strict_ssl)
                                             ->timeout($this->timeout)
                                             ->addHeaders($this->getAuthHeaders())
                                             ->body('grant_type=refresh_token&refresh_token='.$this->getRefreshToken(), 'form')
                                             ->expectsJson()
                                             ->send();

                    dd($this->response);

                    $this->setAccessInformation($this->response->body);
                } catch (\Exception $e) {

                    $this->throwResponseException('POST', $this->response, $e->getMessage());
                }
                //the authObject is in the body of the response object
                return $this->response->body;
            }


            public function getAuthObject($path, $parameters = null)
            {
                try {
                    $this->response = Request::post($this->getUrl(self::AUTH_ENDPOINT, $path))
                                             ->strictSSL($this->strict_ssl)
                                             ->addHeaders($this->determineHeaders())
                                             ->timeout($this->timeout)
                                             ->body($parameters, 'form')
                                             ->expectsJson()
                                             ->send();
                } catch (\Exception $e) {
                    $this->throwResponseException('POST', $this->response, $e->getMessage());
                }
                //the authObject is in the body of the response object
                return $this->response->body;
            }
        */
}