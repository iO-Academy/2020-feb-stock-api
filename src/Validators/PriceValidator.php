<?php

namespace App\Validators;

class PriceValidator extends StringValidator
{
    private const PRICE_REGEX = '/^(0|[1-9]\d*)(\.\d{2})?$/';
    private const MAX_CHAR = 255;
    private const ERROR_MSG = 'Must provide price and be max 255 characters long';

    /**
     * Make sure the price is valid
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
