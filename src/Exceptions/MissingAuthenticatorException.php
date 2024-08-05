<?php

declare(strict_types=1);

namespace Slakbal\Gotowebinar\Exceptions;

use Illuminate\Support\Facades\Log;

class MissingAuthenticatorException extends RequiresReAuthorizationException
{
    public function __construct()
    {
        $message = sprintf('Missing Authenticator. The application needs to be re-authorized to obtain a new Authenticator. Visit %s to authorize your application again.', url()->route('goto.authorize'));

        parent::__construct($message);

        Log::error('GotoApi', ['Message' => $message]);
    }
}
