<?php

namespace Slakbal\Gotowebinar\Exception;

class InvalidResource extends GotoException
{
    public static function missingMethod($key)
    {
        return new static("The `{$key}` method you are trying to set, does not exist on the resource class.");
    }

    public static function missingProperty($key)
    {
        return new static("The `{$key}` property you are trying to set, does not exist on the resource class.");
    }

    public static function missingField($field)
    {
        return new static("The `{$field}` field is required, make sure you are setting it.");
    }
}
