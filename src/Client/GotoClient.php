<?php

namespace Slakbal\Gotowebinar\Client;

use Httpful\Mime;
use Httpful\Request;

final class GotoClient
{
    use Authenticable, PathBuilder, ResultsProcessor;

    protected $strict_ssl = false;

    protected $timeout = 10; //seconds

    protected $path;

    protected $pathKeys;

    protected $parameters;

    protected $payload;


    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }


    public function setPathKeys(array $pathKeys)
    {
        $this->pathKeys = $pathKeys;

        return $this;
    }


    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }


    public function setPayload(array $payload)
    {
        $this->payload = $payload;

        return $this;
    }


    public function get()
    {
        $this->authenticate();

        $response = Request::get($this->buildUrl($this->path, $this->parameters))
                           ->strictSSL($this->strict_ssl)
                           ->addHeaders($this->getAuthorisationHeader())
                           ->timeout($this->timeout)
                           ->expectsJson()
                           ->send();

        return $this->processResult($response);
    }


    public function create()
    {
        $this->authenticate();

        $response = Request::post($this->buildUrl($this->path, $this->parameters))
                           ->strictSSL($this->strict_ssl)
                           ->addHeaders($this->getAuthorisationHeader())
                           ->body($this->payload, Mime::JSON)
                           ->timeout($this->timeout)
                           ->expectsJson()
                           ->send();

        return $this->processResult($response);
    }


    public function update()
    {
        $this->authenticate();

        $response = Request::put($this->buildUrl($this->path, $this->parameters))
                           ->strictSSL($this->strict_ssl)
                           ->addHeaders($this->getAuthorisationHeader())
                           ->body($this->payload, Mime::JSON)
                           ->timeout($this->timeout)
                           ->expectsJson()
                           ->send();

        return $this->processResult($response);
    }


    public function delete()
    {
        $this->authenticate();

        $response = Request::delete($this->buildUrl($this->path, $this->parameters))
                           ->strictSSL($this->strict_ssl)
                           ->addHeaders($this->getAuthorisationHeader())
                           ->timeout($this->timeout)
                           ->expectsJson()
                           ->send();

        return $this->processResult($response);
    }

}