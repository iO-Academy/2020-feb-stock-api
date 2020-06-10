<?php


namespace App\Validators;


class CountryValidator extends StringValidator
{
    private const MAX_CHAR = 255;
    private const ERROR_MSG = 'Must provide a country and be less than 255 characters';

    /**
     * Validates that country exists and within required length
     *
     * @param string $country
     * @return string|null
     * @throws \Exception
     */
    public static function validateCountry(string $country)
    {
        return self::validateExistsAndLength($country, self::MAX_CHAR, self::ERROR_MSG);
    }
}
