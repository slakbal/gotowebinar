<?php

namespace Slakbal\Gotowebinar;

use Slakbal\Gotowebinar\Traits\AccessObject;
use Slakbal\Gotowebinar\Traits\GotoClient;

/**
 * Provides common functionality
 *
 * @abstract
 */
abstract class GotoAbstract
{

    use AccessObject, GotoClient;


    public function __construct($authType)
    {
        $this->checkAccessObject($authType); //check if API authentication is available
    }


    /*
     * Ping if authentication worked and if there is any response from the server
     */
    function state($refresh = false)
    {
        if ($refresh) {
            $this->refreshToken();
        }

        if ($this->hasAccessObject()) {
            return ['state' => 'Access object available', 'accessObject' => $this->getAccessObject()];
        } else {
            return ['state' => 'No access object available', 'accessObject' => null];
        }
    }
}