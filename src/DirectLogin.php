<?php

namespace Slakbal\Gotowebinar;

use Slakbal\Gotowebinar\Traits\GotoClient;

class DirectLogin
{

    use GotoClient;

    protected $path = 'oauth/access_token';


    public function authenticate()
    {
        return $this->getAuthObject($this->path, $this->getParameters());
    }


    private function getParameters()
    {
        return [
            'grant_type' => "password",
            'user_id'    => config('goto.direct.username'),
            'password'   => config('goto.direct.password'),
            'client_id'  => config('goto.direct.client_id'),
        ];
    }

}