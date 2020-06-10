<?php 

namespace App\Validators;

class StockLevelValidator
{
    public static function validateSufficientStock(int $currentProductStock, int $volumeOrdered)
    {
        if (!empty($volumeOrdered) == true && $volumeOrdered <= $currentProductStock) {
            return $volumeOrdered;

        } else {
            throw new \Exception('Insufficient stock');
        }
    }
}