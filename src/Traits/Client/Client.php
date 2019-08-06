<?php

namespace Slakbal\Gotowebinar\Traits\Client;

use Httpful\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Slakbal\Gotowebinar\Exception\GotoException;

trait Client
{
    use Authenticable, PathHelpers;

    protected $timeout = 10; //seconds

    protected $strict_ssl = false;

    private $response;


    public function reauthenticate()
    {
        $this->refreshAuthentication();

        return $this->status();
    }


    public function status()
    {
        if ($this->getAccessToken()) {
            return ['ready' => true, 'access_token' => Str::limit($this->getAccessToken(), (10), '...')];
        }

        return ['ready' => false, 'access_token' => null];
    }


    //returns the body of the rest response
    private function sendAPIRequest($verb, $path, $parameters = null, $payload = null)
    {
        $verb = strtoupper(trim($verb));



        $this->checkAuthentication();

        try {

            switch ($verb) {

                case 'GET':

                    $this->response = Request::get($this->getUrl($path, $parameters))
                                             ->strictSSL($this->strict_ssl)
                                             ->addHeaders($this->getAuthorisationHeader())
                                             ->timeout($this->timeout)
                                             ->expectsJson()
                                             ->send();

                    break;

                case 'POST':

                    $this->response = Request::post($this->getUrl($path, $parameters))
                                             ->strictSSL($this->strict_ssl)
                                             ->addHeaders($this->getAuthorisationHeader())
                                             ->timeout($this->timeout)
                                             ->expectsJson()
                                             ->sendsJson()
                                             ->body($this->preparePayload($payload))
                                             ->send();
                    break;

                case 'PUT':

                    $this->response = Request::put($this->getUrl($path, $parameters))
                                             ->strictSSL($this->strict_ssl)
                                             ->addHeaders($this->getAuthorisationHeader())
                                             ->timeout($this->timeout)
                                             ->expectsJson()
                                             ->sendsJson()
                                             ->body($this->preparePayload($payload))
                                             ->send();
                    break;

                case 'DELETE':

                    $this->response = Request::delete($this->getUrl($path, $parameters))
                                             ->strictSSL($this->strict_ssl)
                                             ->addHeaders($this->getAuthorisationHeader())
                                             ->timeout($this->timeout)
                                             ->expectsJson()
                                             ->send();
                    break;

                default:

                    break;
            }
        } catch (\Exception $e) {

            $this->throwResponseException($verb, $this->response, $e->getMessage());
        }

        return $this->processResultCode($verb, $this->response);
    }


    /**
     * @param $response
     *
     * @throws GotoException
     */
    private function processResultCode($verb, $response)
    {
        if ($response->code >= Response::HTTP_BAD_REQUEST) { //if any error range
            $this->throwResponseException($verb, $response);
        } else {
            if (in_array($verb, [
                'DELETE',
                'UPDATE',
                'PUT',
            ])) {
                if (is_null($response->body) || empty($response->body)) {
                    return true; //if the response is empty return at least true otherwise return the ->body
                }
            }
        }

        return $response->body;
    }


    private function throwResponseException($verb, $response, $exceptionMessage = null): void
    {
        $this->message = $this->getResponseStatusText($response->code);

        $payload = isset($response->payload) ? json_encode($response->payload) : 'no payload';

        ($exceptionMessage) ? Log::error('GOTOWEBINAR: HTTP Exception: ' . $this->message . ' - ' . $exceptionMessage . ' - Payload: ' . $payload) : null;

        if ($response->hasErrors() && $response->hasBody()) {
            switch ($response->code) {
                case Response::HTTP_CONFLICT:
                    Log::error('GOTOWEBINAR: ' . $verb . ' - ' . $this->message . ': ' . $response->body->description);
                    throw new GotoException($this->message . ' - ' . $response->body->description);

                    break;

                default:
                    Log::error('GOTOWEBINAR: ' . $verb . ' - ' . $this->message . ': ' . $response->body->description);
                    throw new GotoException($this->message . ' - ' . $response->body->description);
            }
        }

        throw new GotoException($this->message . ' - There was an error, make sure the API endpoint-url exist, config is correct');
    }


    private function getResponseStatusText($responseCode)
    {
        return isset($responseCode) ? Response::$statusTexts[$responseCode] . ' (' . $responseCode . ')' : 'unknown status';
    }


    private function preparePayload($payload)
    {
        return $payload->toArray();
    }

}