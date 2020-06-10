<?php 

namespace App\Validators;

class StockLevelValidator extends StringValidator
{
    private const STOCK_LEVEL_REGEX = '/^\d+$/';
    private const MAX_CHAR = 11;
    private const ERROR_MSG = 'Must provide stock level and be max 11 characters long';

    /**
     * Checks the following:
     *  - That stock is provided and is max 11 characters.
     *  - That a valid stock level was provided.
     *
     * @param string $stockLevel
     * @return string|null
     * @throws \Exception
     */
    public static function validateStockLevel(string $stockLevel)
    {
        $stockLevel = self::validateExistsAndLength($stockLevel, self::MAX_CHAR, self::ERROR_MSG);

        if (!preg_match(self::STOCK_LEVEL_REGEX, $stockLevel)) {
            throw new \Exception('Invalid stock level');
        }

        return $stockLevel;
    }
}
