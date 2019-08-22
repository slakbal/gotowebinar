<?php

namespace Slakbal\Gotowebinar\Traits\Client;

trait PathHelpers
{
    public function getPathRelativeToOrganizer($relativePathSection = null)
    {
        $this->authenticate(); //the path requires the organiser key which is in the auth object

        return sprintf('organizers/%s/', $this->getOrganizerKey()) . trim($relativePathSection, '/');
    }


    public function getPathRelativeToAccount($relativePathSection = null)
    {
        $this->authenticate(); //the path requires the organiser key which is in the auth object

        return sprintf('accounts/%s/', $this->getAccountKey()) . trim($relativePathSection, '/');
    }


    private function getUrl($path, $parameters = null)
    {
        return $this->getPath(self::API_ENDPOINT, $path, $parameters);
    }


    private function getPath($baseUri, $path, $parameters = null)
    {
        if (is_null($parameters)) {
            return $this->cleanPath($baseUri, $path);
        }

        return $this->cleanPath($baseUri, $path) . '?' . http_build_query($parameters);
    }


    private function cleanPath($baseUri, $path)
    {
        return trim($baseUri, '/') . '/' . trim($path, '/');
    }

}