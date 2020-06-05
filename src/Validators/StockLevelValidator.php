<?php 

namespace Portal\Validators;

class StockLevelValidator
{
    private const STOCK_LEVEL_REGEX = '/^\d+$/';

    public static function validateStockLevel(string $stockLevel)
    {
        if (preg_match(self::STOCK_LEVEL_REGEX, $stockLevel)) {
            return $stockLevel;
        } else {
            throw new Exception('Invalid stock level');
        }
    }
}