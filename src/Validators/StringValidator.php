<?php

namespace App\Validators;

abstract class StringValidator
{
    /**
     * Validate that a string exists and is within length allowed, throws an error if not
     *
     * @param string $validateData
     * @param int $maxCharacterLength
     * @param string $errorMsg
     * @return string, which will return the validateData
     * @throws \Exception if the array is empty
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
