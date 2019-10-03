<?php

namespace Slakbal\Gotowebinar\Client;

use Httpful\Mime;
use Httpful\Request;
use Slakbal\Gotowebinar\Exception\GotoException;

final class GotoClient
{
    use Authenticable, PathBuilder;

    protected $strict_ssl = false;

    protected $timeout = 10; //seconds

    protected $path;

    protected $pathKeys;

    protected $parameters;

    protected $payload;

    const GET = 'GET';

    const POST = 'POST';

    const PUT = 'PUT';

    const DELETE = 'DELETE';

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

        return $this->processResponse($response, self::GET);
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

        return $this->processResponse($response, self::POST);
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

        return $this->processResponse($response, self::PUT);
    }

    public function delete()
    {
        $this->authenticate();

        $response = Request::delete($this->buildUrl($this->path, $this->parameters))
                           ->strictSSL($this->strict_ssl)
                           ->addHeaders($this->getAuthorisationHeader())
                           ->body(null, Mime::JSON)
                           ->timeout($this->timeout)
                           ->expectsJson()
                           ->send();

        return $this->processResponse($response, self::DELETE);
    }

    private function processResponse($response, $verb)
    {
        if ($response->code >= 100 && $response->code < 300) {
            switch ($verb) {
                case self::DELETE:
                    return true;
                    break;
                case self::PUT:
                    return true;
                    break;
                default:
                    return $response->body;
            }
        }

        throw GotoException::responseException($response, 'HTTP Response code: '.$response->code, $verb);
        /*
        if ($response->code >= Response::HTTP_BAD_REQUEST) {
            throw GotoException::responseException($response, 'Response code: '.$response->code, $verb);
        }
        */
    }
}
