<?php 

namespace App\Validators;

class SufficientStockValidator
{
    /**
     * checks the following:
     * - if products ordered SKU's are valid
     * - that volume order is not 0.
     * - that the volume ordered does not exceed the stock available for a product.
     *
     * @param array $orderedProducts
     * @param array $productsStockLevels
     * @return bool true if no checks failed.
     * @throws \Exception thrown if checks above fail.
     */
    public static function checkSufficientStock(array $orderedProducts, array $productsStockLevels): bool
    {
        if (count($orderedProducts) !== count($productsStockLevels)){
            throw new \Exception('Some SKUs provided do not exist in DB');
        }

        for ($i = 0; $i < count($orderedProducts); $i++) {
            $volume = $orderedProducts[$i]['volumeOrdered'];
            if ($volume === 0){
                throw new \Exception("Volume ordered for product with SKU (" . $orderedProducts[$i]['sku'] . ") must be larger than 0");
            }

            $stockLevel = $productsStockLevels[$i]['stockLevel'];
            if ($volume > $stockLevel) {
                throw new \Exception("Volume ordered for product with SKU (" . $orderedProducts[$i]['sku'] . ") is higher than current stock");
            }
        }

        return true;
    }
}
