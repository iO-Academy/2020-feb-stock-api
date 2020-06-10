<?php

namespace App\Validators;

class OrderNumberValidator extends StringValidator
{
    private const MIN_CHAR = 5;
    private const MAX_CHAR = 20;
    private const ERROR_MSG = 'Order number must be between 5 and 20 characters and contain no special characters';

    /**
     * Make sure the Order Number is valid
     *
     * @param string $sku
     * @return string|null
     * @throws \Exception
     */
    public static function validateOrderNumber(string $orderNumber)
    {
        return StringValidator::validateNoSpecialCharacters($orderNumber, self::MIN_CHAR, self::MAX_CHAR, self::ERROR_MSG);
    }
}