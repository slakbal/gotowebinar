<?php

namespace Slakbal\Gotowebinar\Objects;

class EntityAbstract
{
    public function determineLocale()
    {
        switch (strtolower(config('app.locale'))) {
            case 'en':
                return 'en_US';
                break;
            case 'de':
                return 'de_DE';
                break;
            default:
                return;
        }
    }

    public function toArray()
    {
        //list of variables to be filtered out
        $ignore = [
            'webinarKey',
            'registrationUrl',
            'participants',
        ];

        return array_where(get_object_vars($this), function ($value, $key) use ($ignore) {
            if (! in_array($key, $ignore)) {
                return ! empty($value);
            }
        });
    }
}
