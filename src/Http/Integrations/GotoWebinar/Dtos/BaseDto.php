<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos;

use Illuminate\Support\Str;

abstract class BaseDto
{
    public function limit(int $maxLength, string $value, ?string $suffix = null): string
    {
        if (empty($value)) {
            return $value;
        }

        $maxLength = ($maxLength - 3);

        if (! empty($suffix)) {
            $suffix_length = Str::length($suffix);
            $subject_length = Str::length($value);

            if (($suffix_length + $subject_length) > $maxLength) {
                return Str::limit($value, (128 - ($suffix_length + 3)), $suffix.'...');
            }

            return $value.$suffix;

        } else {
            return Str::limit($value, $maxLength);
        }
    }
}
