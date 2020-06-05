<?php 

namespace Portal\Validators;

class StockLevelValidator
{
    private const STOCK_LEVEL_REGEX = '/^\d+$/';

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
