<?php

namespace App\Validators;

class SkuValidator extends StringValidator
{
    private const MIN_CHAR = 10;
    private const MAX_CHAR = 20;
    private const ERROR_MSG = 'Input must not have special characters';

    /**
     * Make sure the SKU is valid 
     *
     * @param string $sku
     * @return string|null
     * @throws \Exception
     */
    public static function validateSku(string $sku)
    {
        return StringValidator::validateNoSpecialCharacters($sku, self::MIN_CHAR, self::MAX_CHAR, self::ERROR_MSG);
    }
}
