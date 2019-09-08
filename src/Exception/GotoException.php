<?php

namespace Slakbal\Gotowebinar\Exception;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class GotoException extends \Exception
{
    public static function responseException($response, $customMessage = null)
    {
        $message = self::getResponseMessage($response, $customMessage);

        Log::error('GOTOWEBINAR: '.$message.' Payload: '.json_encode($response->body));

        return new static($message);
    }

    private static function getResponseMessage($response, $customMessage = null)
    {
        $message = Response::$statusTexts[$response->code];

        if ($response->hasErrors() && $response->hasBody()) {
            $message .= ' - '.$response->body->description;
        }

        if ($customMessage) {
            $message = $message.' - '.$customMessage;
        }

        return $message;
    }
}
