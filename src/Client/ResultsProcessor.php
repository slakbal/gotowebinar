<?php

namespace Slakbal\Gotowebinar\Client;

use Httpful\Request;
use Illuminate\Http\Response;
use Slakbal\Gotowebinar\Exception\GotoException;

trait ResultsProcessor
{
    /**
     * @param $response
     *
     * @throws GotoException
     */
    private function processResult($response)
    {
        if ($response->code >= Response::HTTP_BAD_REQUEST) { //if any error range

            //do some proper error handling here
            return $response->body;
            //$this->throwResponseException($verb, $response);
        }

        if (is_null($response->body) || empty($response->body)) {
            return true; //if the response is empty return at least true otherwise return the ->body
        }

        return $response->body;
    }


    private function getResponseMessage($response)
    {
        switch ($response->code) {
            case Response::HTTP_OK:

                return Response::$statusTexts[Response::HTTP_OK];

                break;

            case Response::HTTP_ACCEPTED:

                return Response::$statusTexts[Response::HTTP_ACCEPTED];

                break;

            case Response::HTTP_CREATED:

                return Response::$statusTexts[Response::HTTP_CREATED] . ' - The resource was created.';

                break;

            case Response::HTTP_NO_CONTENT:

                return Response::$statusTexts[Response::HTTP_NO_CONTENT];

                break;

            case Response::HTTP_BAD_REQUEST:

                return Response::$statusTexts[Response::HTTP_BAD_REQUEST] . ' - Possible missing data in the payload.';

                break;

            case Response::HTTP_FORBIDDEN:

                return Response::$statusTexts[Response::HTTP_FORBIDDEN];

                break;

            case Response::HTTP_NOT_FOUND:

                return Response::$statusTexts[Response::HTTP_NOT_FOUND];

                break;

            case Response::HTTP_METHOD_NOT_ALLOWED:

                return Response::$statusTexts[Response::HTTP_METHOD_NOT_ALLOWED] . ' - Webinar is in the past.';

                break;

            case Response::HTTP_CONFLICT:

                return Response::$statusTexts[Response::HTTP_CONFLICT] . ' - Resource already create or in session.';

                break;

            default:

                return null;

                break;
        }
    }

}