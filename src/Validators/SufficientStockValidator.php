<?php 

namespace App\Validators;

class SufficientStockValidator
{
    /**
     * checks the following:
     * - if products ordered SKU's are valid
     * - that the volume ordered does not exceed the stock available for a product.
     *
     * @param array $orderedProducts
     * @param array $productsStockLevels
     * @throws \Exception thrown if checks above fail.
     */
    public static function checkSufficientStock(array $orderedProducts, array $productsStockLevels): void
    {
        if (count($orderedProducts) !== count($productsStockLevels)){
            throw new \Exception('Some SKUs provided do not exist in DB');
        }

        for ($i = 0; $i < count($orderedProducts); $i++) {
            $volume = $orderedProducts[$i]['volumeOrdered'];
            $stockLevel = $productsStockLevels[$i]['stockLevel'];

            if ($volume > $stockLevel) {
                throw new \Exception("Volume ordered for product with SKU: " . $orderedProducts[$i]['sku'] . " is higher than current stock");
            }
        }

        return;
    }
}
