<?php

namespace App\Validators;

class CityValidator extends StringValidator
{
    private const MAX_CHAR = 255;
    private const ERROR_MSG = 'Must provide a city and be less than 255 characters';

    /**
     * Validates city exists and is les that 255 chars
     *
     * @param string $city
     * @return string|null
     * @throws \Exception
     */
    public static function validateCity(string $city)
    {
        return self::validateExistsAndLength($city, self::MAX_CHAR, self::ERROR_MSG);
    }
}
