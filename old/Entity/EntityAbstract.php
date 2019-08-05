<?php

namespace Slakbal\Gotowebinar\Old\Entity;


class EntityAbstract
{
    public function determineLocale()
    {
        switch (strtolower(config('app.locale'))) {
            case "en":
                return "en_US";
                break;
            case "de":
                return "de_DE";
                break;
            default:
                return null;
        }
    }

    public function toArray()
    {
        //list of variables to be filtered
        $blacklist = [
            'webinarKey',
            'registrationUrl',
            'participants',
        ];

        return array_where(get_object_vars($this), function ($value, $key) use ($blacklist) {

            if (!in_array($key, $blacklist)) {
                return !empty($value);
            }

        });
    }
}