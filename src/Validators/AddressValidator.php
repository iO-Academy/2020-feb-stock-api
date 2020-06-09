<?php

namespace App\Validators;

class AddressValidator extends StringValidator
{
    private const ADDRESS_REGEX = '/^[a-z0-9- ]+$/i';

    /**
     * Ensures valid address
     * @param string $address
     * @return string
     * @throws \Exception
     */
    public static function validateAddress(string $address)
    {
        if (preg_match(self::ADDRESS_REGEX, $address)) {
            return $address;
        } else {
            throw new \Exception('Invalid address');
        }
    }
}