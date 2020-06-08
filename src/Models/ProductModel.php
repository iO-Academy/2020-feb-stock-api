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

        return $result > 0;
    }
}
