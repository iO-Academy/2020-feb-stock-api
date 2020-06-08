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
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Gets all products from Database
     * @return array|false depending on successful query or not
     */
    public function getAllProducts()
    {
        $query = $this->db->query('SELECT `sku`, `name`, `price`, `stockLevel` FROM `products`;');

        if ($query){
            return $query->fetchAll();
        }

        return $query;
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

    public function checkProductExists(string $sku): bool
    {
        $query = $this->db->prepare("SELECT `id` FROM `products` WHERE `sku` = '$sku'");
        $result = $query->execute();

        if(mysqli_num_rows($result) == 0) {
            false;
        } else {
            true;
        }
    }
}
