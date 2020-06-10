<?php

namespace App\Validators;

class NameValidator extends StringValidator
{
    private const MAX_CHAR = 255;
    private const ERROR_MSG = 'Must provide product name must exist and be max 255 characters long';

    /**
     * Does the following:
     *  - Sanitises the name by removed unwanted characters and whitespace.
     *  - Makes sure the name is provided and is a maximum of 255 characters.
     *
     * @param string $name
     * @return string
     * @throws \Exception
     */
    public static function validateName(string $name)
    {
        $name = self::sanitiseString($name);
        return self::validateExistsAndLength($name, self::MAX_CHAR, self::ERROR_MSG);
    }
}
