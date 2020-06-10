<?php 

namespace App\Validators;

class SufficientStockValidator
{
    public static function checkSufficientStock(array $orderedProducts, array $productsStockLevels): void
    {
        if (count($orderedProducts) !== count($productsStockLevels)){
            throw new \Exception('Some SKUs provided for ordered products are invalid');
        }

        for ($i = 0; $i < count($orderedProducts); $i++) {
            $volume = $orderedProducts[$i]['volumeOrdered'];
            $stockLevel = $productsStockLevels[$i]['stockLevel'];

            if ($volume > $stockLevel) {
                throw new \Exception("Volume ordered for SKU: " . $orderedProducts[$i]['sku'] . " is higher than current stock");
            }
        }

        return;
    }
}
