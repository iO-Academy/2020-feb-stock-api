<?php

namespace App\Utilities;

class OrderUtilities
{
    /**
     * Calculates the adjusted stock levels after taking into account the new order's volume.
     *
     * @param array $orderedProducts containing SKUs and volumeOrdered
     * @param array $productsStockLevels containing SKUs and stockLevels
     * @return array containing SKUs, volumeOrdered and newStockLevels
     */
    public static function calcAdjustedStockLevels(array $orderedProducts, array $productsStockLevels): array
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
