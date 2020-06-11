<?php

namespace App\Validators;

class AddressValidator extends StringValidator
{
    private const ADDRESS_REGEX = '/^[a-z0-9- ]+$/i';
    private const MAX_CHAR = 255;
    private const ERROR_MSG = 'Must provide address and be less than 255 characters';

    /**
     * Ensures valid address
     * @param string $address
     * @return string
     * @throws \Exception
     */
    public static function validateAddress(string $address)
    {
        if (preg_match(self::ADDRESS_REGEX, $address)) {
            return self::validateExistsAndLength($address, self::MAX_CHAR, self::ERROR_MSG);
        } else {
            throw new \Exception('Invalid address');
        }
    }
}
