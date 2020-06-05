<?php

namespace Portal\Validators;

class NameValidator
{
    public static function validateExistsAndLength(string $validateName, int $characterLength)
    {
        if (empty($validateName) == false && strlen($validateName) <= $characterLength) {
            return $validateName;
        } else {
            throw new \Exception('An input string does not exist or is too long');
        }
    }

    public static function validateLength(string $validateName, int $characterLength)
    {
        if ($validateName == '') {
            return null;
        } elseif (strlen($validateName) <= $characterLength) {
            return $validateName;
        } else {
            throw new \Exception('An input string does not exist or is too long');
        }
    }

    public static function sanitiseString($validateName)
    {
        return trim(filter_var($validateData, FILTER_SANITIZE_STRING));
    }
}
