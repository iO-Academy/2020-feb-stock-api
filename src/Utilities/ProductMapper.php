<?php

namespace App\Utilities;

use App\Entities\ProductEntity;

class ProductMapper
{
    public static function ProductEntity($sku, $name, $price, $stockLevel)
    {
        return new ProductEntity($sku, $name, $price, $stockLevel);
    }

}
