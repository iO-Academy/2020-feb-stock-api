<?php

namespace App\Validators;

abstract class StringValidator
{
    /**
     * Validate that a string exists and is within length provided, and throws exception with error message if not.
     *
     * @param string $validateData
     * @param int $maxCharacterLength
     * @param string $errorMsg
     * @return string|null will return the string that was validated if it's valid.
     * @throws \Exception
     */
    protected static function validateExistsAndLength(string $validateData, int $maxCharacterLength, string $errorMsg = 'An input string does not exist or is too long')
    {
        if (!empty($validateData) == true && strlen($validateData) <= $maxCharacterLength) {
            return $validateData;
        } else {
            throw new \Exception($errorMsg);
        }
    }

    protected static function sanitiseString($validateData)
    {
        return trim(filter_var($validateData, FILTER_SANITIZE_STRING));
    }
}
