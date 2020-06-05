<?php

namespace Portal\Validators;

class SKUValidator extends StringValidator
{
    private const SKU_REGEX = '/^[a-z0-9A-Z]{10,20}$/';

    /**
     * Make sure the SKU is valid
     *
     * @param string $SKU
     * @return string|null
     * @throws \Exception
     */
    public static function validateSKU(string $SKU)
    {
        if (preg_match(self::PRICE_REGEX, $SKU)) {
            return $SKU;
        } else {
            throw new \Exception('Invalid SKU');
        } 
    }
}
