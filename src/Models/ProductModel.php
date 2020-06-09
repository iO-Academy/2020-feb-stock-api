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
     * @return array contains all active products in DB
     */
    public function getAllProducts(): array
    {
        $query = $this->db->query('SELECT `sku`, `name`, `price`, `stockLevel` 
                                                FROM `products` 
                                                WHERE `deleted` = 0;');

        return $query->fetchAll();
    }

    /**
     * @param ProductEntityInterface $productEntity
     * @return bool if product has been added successfully to DB
     */
    public function addProduct(ProductEntityInterface $productEntity): bool
    {
        $array = [
            "sku"=>$productEntity->getSku(),
            "name"=>$productEntity->getName(),
            "price"=>$productEntity->getPrice(),
            "stockLevel"=>$productEntity->getStockLevel()
        ];

        $query = $this->db->prepare("INSERT INTO `products`
                                        (`sku`, `name`, `price`, `stockLevel`)
                                            VALUES (:sku, :name, :price, :stockLevel)");

        return $query->execute($array);
    }

    /**
     * @param string $sku
     * @return bool whether the product was found in DB or not
     */
    public function checkProductExists(string $sku): bool
    {
        $query = $this->db->prepare("SELECT `id` FROM `products` WHERE `sku` = ?");
        $query->execute([$sku]);
        $result = $query->fetch();

        return !empty($result);
    }

    public function getProductBySKU(string $sku): array
    {
        $query = $this->db->prepare("SELECT `sku`, `name`, `price`, `stockLevel` FROM `products` WHERE `sku` = ?");
        $query->execute([$sku]);

        return $query->fetch();
    }
}
