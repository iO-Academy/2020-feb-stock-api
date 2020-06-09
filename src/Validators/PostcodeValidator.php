<?php


namespace App\Validators;


class PostcodeValidator
{
    /**
     * Validates postcode
     * @param string $postcode
     * @return string
     * @throws \Exception
     */
    public static function validatePostcode(string $postcode)
    {
        $postcode = strtoupper(str_replace(' ','', $postcode));
        if(preg_match("/(^[A-Z]{1,2}[0-9R][0-9A-Z]?[\s]?[0-9][ABD-HJLNP-UW-Z]{2}$)/i", $postcode) || preg_match("/(^[A-Z]{1,2}[0-9R][0-9A-Z]$)/i", $postcode)) {
            return $postcode;
        } else {
            throw new \Exception('Invalid postcode');
        }
    }
}