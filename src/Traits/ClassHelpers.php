<?php

namespace Slakbal\Gotowebinar\Traits;

use Slakbal\Gotowebinar\Exception\InvalidResource;

trait ClassHelpers
{
    //if any of the data is set in the array set the properties
    protected function setDataByMethod(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (! method_exists($this, $key)) {
                throw InvalidResource::missingMethod($key);
            }

            $this->$key($value);
        }
    }

    protected function setDataByProperty(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (! property_exists($this, $key)) {
                throw InvalidResource::missingProperty($key);
            }

            $this->$key = $value;
        }
    }

    protected function validate(array $requiredFields = [])
    {
        //todo GotoIssue: validation for the webinars time properties aren't working yet when creating a new webinar
        foreach ($requiredFields as $requiredField) {
            if (in_array($requiredField, ['webinarKey', 'registrantKey'])) {
                if (empty($this->pathKeys[$requiredField])) {
                    throw InvalidResource::missingField($requiredField);
                }
            } elseif (is_null($this->$requiredField)) {
                throw InvalidResource::missingField($requiredField);
            }
        }
    }

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
}
