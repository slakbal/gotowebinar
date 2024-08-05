<?php

declare(strict_types=1);

namespace Slakbal\Gotowebinar\Exceptions;

use Illuminate\Support\Facades\Log;

class MissingAuthorizationException extends RequiresReAuthorizationException
{
    public function __construct()
    {
        $message = sprintf('The application needs to got through the Authorization flow at least once to obtain an Authorization code. Visit %s to authorize your application.', url()->route('goto.authorize'));

        parent::__construct($message);

        Log::error('GotoApi', ['Message' => $message]);
    }
}
