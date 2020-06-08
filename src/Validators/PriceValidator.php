<?php

namespace App\Validators;

class PriceValidator extends StringValidator
{
    private const PRICE_REGEX = '/^(0|[1-9]\d*)(\.\d{2})?$/';

    /**
     * Make sure the price is valid
     *
     * @param string $price
     * @return string|null
     * @throws \Exception
     */
    public static function validatePrice(string $price)
    {
        if (preg_match(self::PRICE_REGEX, $price)) {
            return $price;
        } else {
            throw new \Exception('Invalid price');
        } 
    }
}
