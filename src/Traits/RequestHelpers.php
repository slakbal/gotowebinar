<?php

namespace Slakbal\Gotowebinar\Traits;

trait RequestHelpers
{
    /**
     * Returns the payload for the message (alias for toArray).
     *
     * @return array
     */
    public function getPayload()
    {
        return $this->toArray2();
    }

    /**
     * Convert the object parameters to an array and remove exclusions.
     *
     * @return array
     */
    public function toArray()
    {
        $values = get_object_vars($this);

        $exclusions = $this->getPayloadExclusions();

        if (count($exclusions) > 0) {
            $values = array_diff_key($values, array_flip($exclusions));
        }

        return $values;
    }

    public function toArray2()
    {
        //list of variables to be filtered out
        $ignore = $this->getPayloadExclusions();

        return array_where(get_object_vars($this), function ($value, $key) use ($ignore) {
            if (! in_array($key, $ignore)) {
                return ! empty($value);
            }
        });
    }

    /** Override this on resource class level to be specific what fields should be excluded from the payload **/
    protected function getPayloadExclusions(): array
    {
        //standard exclusions
        $exclusions = $this->getBaseExclusions();

        if (is_array($this->queryParameters)) {
            //filter out the custom values and also any query parameters that might be added
            $exclusions = array_merge($exclusions, array_keys($this->queryParameters));
        }

        if (is_array($this->excludeFromPayload())) {
            //filter out the custom values that might be added on the class instance
            $exclusions = array_merge($exclusions, $this->excludeFromPayload());
        }

        return $exclusions;
    }
}
