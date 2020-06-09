<?php

namespace App\Validators;

class SkuOrderValidator extends StringValidator
{
    private const SKU_ORDER_REGEX = '/^[a-z0-9A-Z]{10,20}$/';

    /**
     * Make sure the SKU/Order number is valid
     *
     * @param string $sku
     * @return string|null
     * @throws \Exception
     */
    public static function validateSkuAndOrder(string $sku)
    {
        if (preg_match(self::SKU_ORDER_REGEX, $sku)) {
            return $sku;
        } else {
            throw new \Exception('Invalid input');
        } 
    }
}
