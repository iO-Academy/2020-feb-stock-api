<?php

namespace App\Validators;

class SkuValidator
{
    private const SKU_REGEX = '/^[a-z0-9A-Z]{10,20}$/';

    /**
     * Make sure the SKU is valid 
     *
     * @param string $sku
     * @return string|null
     * @throws \Exception
     */
    public static function validateSku(string $sku)
    {
        if (preg_match(self::SKU_REGEX, $sku)) {
            return $sku;
        } else {
            throw new \Exception('Invalid SKU');
        } 
    }
}
