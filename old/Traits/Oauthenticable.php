<?php

namespace Traits;

use Httpful\Request;

trait Oauthenticable
{
    protected $AUTH_uri = 'https://api.getgo.com';

    public function getAuthObject($path, $parameters = null)
    {
        try {
            $this->response = Request::post($this->getUrl($this->AUTH_uri, $path))
                                     ->strictSSL($this->verify_ssl)
                                     ->addHeaders($this->determineHeaders())
                                     ->timeout($this->timeout)
                                     ->body($parameters, 'form')
                                     ->expects('json')
                                     ->send();
        } catch (\Exception $e) {
            $this->throwResponseException('POST', $this->response, $e->getMessage());
        }
        //the authObject is in the body of the response object
        return $this->response->body;
    }
}