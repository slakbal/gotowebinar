<?php

namespace Slakbal\Gotowebinar;

use Slakbal\Gotowebinar\Old\Traits\GotoClient;

class DirectLogin
{

    use GotoClient;

    protected $path = 'oauth/v2/token';


    public function authenticate()
    {
        return $this->getAuthObject($this->path, $this->getParameters());
    }


    private function getParameters()
    {
        return [
            'grant_type' => "password",
            'username'    => config('goto.direct.username'),
            'password'   => config('goto.direct.password')
        ];
    }
}
