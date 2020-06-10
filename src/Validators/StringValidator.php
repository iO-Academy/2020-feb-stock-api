<?php

namespace App\Validators;

abstract class StringValidator
{
    /**
     * Validate that a string exists and is within length allowed, throws an error if not
     *
     * @param string $validateData
     * @param int $characterLength
     * @return string, which will return the validateData
     * @throws \Exception if the array is empty
     */
    public static function validateExistsAndLength(string $validateData, int $maxCharacterLength)
    {
        if (!empty($validateData) == true && strlen($validateData) <= $maxCharacterLength) {
            return $validateData;
        } else {
            throw new \Exception('An input string does not exist or is too long');
        }
    }

    public static function sanitiseString($validateData)
    {
        return trim(filter_var($validateData, FILTER_SANITIZE_STRING));
    }

    public static function validateNoSpecialCharacters($string, int $minChar, int $maxChar, string $message = 'Input must not have special characters')
    {
        $regex = '/^[a-z0-9A-Z]{' . $minChar . ',' .  $maxChar . '}$/';
        if (preg_match($regex, $string)) {
            return $string;
        } else {
            throw new \Exception($message);
        }
    }
}
