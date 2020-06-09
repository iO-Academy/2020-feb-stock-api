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
     * Adds a product to the Database
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
     * @param ProductEntityInterface $productEntity
     * @return bool if product has been updated successfully in DB
     */
    public function updateProduct(ProductEntityInterface $productEntity): bool
    {
        $array = [
            "sku"=>$productEntity->getSku(),
            "name"=>$productEntity->getName(),
            "price"=>$productEntity->getPrice(),
            "stockLevel"=>$productEntity->getStockLevel()
        ];

        $query = $this->db->prepare("UPDATE `products`
                                        SET `name` = :name,
                                            `price` = :price,
                                            `stockLevel` = :stockLevel
                                        WHERE `sku` = :sku;");

        return $query->execute($array);
    }

    /**
     * Checks if product exists in Database
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

    /**
     * Soft deletes product from Database and updates stock to 0 for said product
     * @param string $sku
     * @return bool whether the operation was successful or not
     */
    public function deleteProductBySku(string $sku): bool
    {
        $query = $this->db->prepare("UPDATE `products`
                                        SET `deleted` = 1
                                            `stockLevel` = 0
                                        WHERE `sku` = ?");

        return $query->execute([$sku]);
    }
}
