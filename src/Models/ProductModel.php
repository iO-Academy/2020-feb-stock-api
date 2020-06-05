<?php


namespace App\Models;


use App\Interfaces\ProductEntityInterface;
use App\Interfaces\ProductModelInterface;

class ProductModel implements ProductModelInterface
{
    private $db;

    /**
     * ProductModel constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addProduct(ProductEntityInterface $productEntity)
    {
        $array = ["sku"=>$productEntity->getSku(), "name"=>$productEntity->getName(),
            "price"=>$productEntity->getPrice(), "stockLevel"=>$productEntity->getStockLevel()];

        $query = $this->db->prepare("UPDATE `products`
                                    SET `sku` = :sku
                                        `name` = :name
                                        `price` = :price
                                        `stockLevel` = :stockLevel
        ");
        $result = $query->execute($array);
        return $result;
    }
}
