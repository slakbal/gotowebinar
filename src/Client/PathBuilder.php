<?php

namespace Slakbal\Gotowebinar\Client;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

trait PathBuilder
{
    /**
     * The type of the encoding in the query.
     *
     * @var int Can be either PHP_QUERY_RFC3986 or PHP_QUERY_RFC1738.
     */
    protected $encodingType = PHP_QUERY_RFC1738;

    private function buildUrl($path, $parameters = null)
    {
        $path = $this->replaceKeyPlaceholders($path, $this->getPathKeys());

        if (is_null($parameters) || empty($parameters)) {
            return $this->cleanPath($path);
        }

        return $this->cleanPath($path).'?'.http_build_query($parameters, '', '&', $this->encodingType);
    }

    private function cleanPath($path)
    {
        return trim($path, '/');
    }

    private function getPathKeys()
    {
        $keys = [
            'accountKey' => $this->getAccountKey(),
            'organizerKey' => $this->getOrganizerKey(),
        ];

        if (is_array($this->pathKeys)) {
            $keys = array_merge($keys, $this->pathKeys);
        }

        return $keys;
    }

    protected function replaceKeyPlaceholders($path, array $replacements)
    {
        if (empty($replacements)) {
            return $path;
        }

        $replace = $this->sortReplacements($replacements);

        foreach ($replacements as $key => $value) {
            $path = str_replace(
                [':'.$key, ':'.Str::upper($key), ':'.Str::ucfirst($key)],
                [$value, Str::upper($value), Str::ucfirst($value)],
                $path
            );
        }

        return $path;
    }

    /**
     * Sort the replacements array.
     *
     * @param array $replace
     * @return array
     */
    protected function sortReplacements(array $replace)
    {
        return (new Collection($replace))->sortBy(function ($value, $key) {
            return mb_strlen($key) * -1;
        })->all();
    }
}
