<?php

namespace App\Utilities;

class OrderUtilities
{
    public static function calcAdjustedStockLevel(array $orderedProducts, array $productsStockLevels)
    {
        $orderedProductsWithAdjustedStockLevel = $orderedProducts;

        for ($i = 0; $i < count($orderedProducts); $i++) {
            $volume = $orderedProducts[$i]['volumeOrdered'];
            $stockLevel = $productsStockLevels[$i]['stockLevel'];

            $adjustedStockLevel = $stockLevel - $volume;

            $orderedProductsWithAdjustedStockLevel[$i]['newStockLevel'] = $adjustedStockLevel;
        }

        return $orderedProductsWithAdjustedStockLevel;
    }

}
