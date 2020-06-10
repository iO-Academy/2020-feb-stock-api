<?php

namespace App\Validators;

class PriceValidator extends StringValidator
{
    private const PRICE_REGEX = '/^(0|[1-9]\d*)(\.\d{2})?$/';
    private const MAX_CHAR = 13;
    private const ERROR_MSG = 'Must provide price and be max 13 characters long';

    /**
     * Checks the following:
     *  - That price is provided and is max 255 characters.
     *  - That a valid price was provided.
     *
     * @param string $price
     * @return string|null
     * @throws \Exception
     */
    public static function validatePrice(string $price)
    {
        $price = self::validateExistsAndLength($price, self::MAX_CHAR, self::ERROR_MSG);

        if (!preg_match(self::PRICE_REGEX, $price)) {
            throw new \Exception('Invalid price');
        }

        return $price;
    }
}
