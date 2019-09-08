<?php

namespace Slakbal\Gotowebinar\Resources;

use Slakbal\Gotowebinar\Traits\Actions;
use Slakbal\Gotowebinar\Traits\ClassHelpers;
use Slakbal\Gotowebinar\Contract\GotoWebinar;

abstract class AbstractResource implements GotoWebinar
{
    use ClassHelpers, Actions;

    private $baseUrl = 'https://api.getgo.com/G2W/rest/v2';

    protected $queryParameters = [];

    protected $resourcePath = '';

    protected $pathKeys = [];

    /** Override this on resource class level to be specific what fields should be excluded from the payload **/
    protected function excludeFromPayload(): array
    {
        //filter out the custom values and also any query parameters that might be added
        return [];
    }

    /** Override this on resource class level to be specific what fields are required **/
    protected function requiredFields(): array
    {
        return [];
    }

    public function getBaseExclusions()
    {
        return [
            'webinarKey',
            'queryParameters',
            'resourcePath',
            'baseResourcePath',
            'baseUrl',
            'baseAPI',
            'pathKeys',
        ];
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getResourceRelativePath()
    {
        return $this->resourcePath;
    }

    public function getResourceFullPath()
    {
        return $this->getBaseUrl().$this->getResourceRelativePath();
    }
}
