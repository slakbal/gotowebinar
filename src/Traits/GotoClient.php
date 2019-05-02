<?php

namespace Slakbal\Gotowebinar\Traits;

use Httpful\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Slakbal\Gotowebinar\Exception\GotoException;

trait GotoClient
{

    protected $G2W_uri = 'https://api.getgo.com/G2W/rest';

    protected $AUTH_uri = 'https://api.getgo.com';

    protected $timeout = 10; //seconds

    protected $verify_ssl = false;

    private $headers = [];

    private $response;

    private $message = '';


    //returns the body of the rest response
    public function sendRequest($verb, $path, $parameters = null, $payload = null)
    {
        $verb = strtoupper(trim($verb));

        try {
            switch ($verb) {

                case 'GET':

                    $this->response = Request::get($this->getUrl($this->G2W_uri, $path, $parameters))
                                             ->strictSSL($this->verify_ssl)
                                             ->addHeaders($this->determineHeaders())
                                             ->timeout($this->timeout)
                                             ->expectsJson()
                                             ->send();
                    break;

                case 'POST':

                    $this->response = Request::post($this->getUrl($this->G2W_uri, $path, $parameters))
                                             ->strictSSL($this->verify_ssl)
                                             ->addHeaders($this->determineHeaders())
                                             ->timeout($this->timeout)
                                             ->expectsJson()
                                             ->sendsJson()
                                             ->body($payload)
                                             ->send();
                    break;


                case 'PUT':

                    $this->response = Request::put($this->getUrl($this->G2W_uri, $path, $parameters))
                                             ->strictSSL($this->verify_ssl)
                                             ->addHeaders($this->determineHeaders())
                                             ->timeout($this->timeout)
                                             ->expectsJson()
                                             ->sendsJson()
                                             ->body($payload)
                                             ->send();
                    break;

                case 'DELETE':

                    $this->response = Request::delete($this->getUrl($this->G2W_uri, $path, $parameters))
                                             ->strictSSL($this->verify_ssl)
                                             ->addHeaders($this->determineHeaders())
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


    public function getUrl($baseUri, $path, $parameters = null)
    {
        if (is_null($parameters)) {
            return $this->getBasePath($baseUri, $path);
        }

        return $this->getBasePath($baseUri, $path) . '?' . http_build_query($parameters);
    }


    public function getBasePath($baseUri, $path)
    {
        return trim($baseUri, '/') . '/' . trim($path, '/');
    }


    public function getPathRelativeToOrganizer($relativePathSection = null)
    {
        return sprintf('organizers/%s/', $this->getOrganizerKey()) . trim($relativePathSection, '/');
    }


    public function getPathRelativeToAccount($relativePathSection = null)
    {
        return sprintf('accounts/%s/', $this->getAccountKey()) . trim($relativePathSection, '/');
    }


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

    private function determineHeaders()
    {
        //if the accessObject exist it means the API can probably authenticate by token, thus add it to the headers
        if (cache()->has('GOTO_ACCESS_OBJECT')) {
            $this->headers['Authorization'] = $this->getAccessToken();
        } else {
            $this->headers = [
                'Authorization' => 'Basic ' . base64_encode(config('goto.direct.client_id') . ':' . config('goto.direct.client_secret'))
            ];
        }
        return $this->headers;
    }


    private function throwResponseException($verb, $response, $exceptionMessage = null): void
    {
        $this->message = $this->getResponseMessage($response->code);

        ($exceptionMessage) ? Log::error('GOTOWEBINAR: HTTP Exception: ' . $this->message . ' - ' . $exceptionMessage . ' Payload: ' . json_encode($response->payload)) : null;

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

        throw new GotoException($this->message . ' - There was an error, make sure the API endpoint-url exist and if all the required data is given to the request');
    }

    private function getResponseMessage($responseCode)
    {
        return isset($responseCode) ? Response::$statusTexts[$responseCode] . ' (' . $responseCode . ')' : 'unknown status';
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
                    return true; //return true if it was not an error and if the VERB was completed
                }
            }
        }

        return $response->body;
    }
}
