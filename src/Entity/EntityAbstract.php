<?php

namespace Slakbal\Gotowebinar\Entity;


class EntityAbstract
{

    public function toArray()
    {
        //list of variables to be skipped
        $toUnset = [
            'webinarKey',
            'registrationUrl',
            'participants',
        ];

        return array_where(get_object_vars($this), function ($value, $key) use ($toUnset) {

            if (!in_array($key, $toUnset)) {
                return !empty($value);
            }

        });
    }
}