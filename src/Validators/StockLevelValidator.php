<?php 

namespace App\Validators;

class StockLevelValidator extends StringValidator
{
    private const STOCK_LEVEL_REGEX = '/^\d+$/';
    private const MAX_CHAR = 11;
    private const ERROR_MSG = 'Must provide stockLevel and be max 11 characters long';

    /**
     * Make sure the stockLevel is valid
     *
     * @param string $stockLevel
     * @return string|null
     * @throws \Exception
     */
    public static function validateStockLevel(string $stockLevel)
    {
        if (preg_match(self::STOCK_LEVEL_REGEX, $stockLevel)) {
            return $stockLevel;
        } else {
            throw new \Exception('Invalid stock level');
        }
    }
}
