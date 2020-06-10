<?php

namespace App\Validators;

class NameValidator extends StringValidator
{
    private const MAX_CHAR = 255;
    private const ERROR_MSG = 'Must provide product name must exist and be max 255 characters long';

    public static function validateName(string $name)
    {
        $name = self::sanitiseString($name);
        return self::validateExistsAndLength($name, self::MAX_CHAR, self::ERROR_MSG );
    }
}
