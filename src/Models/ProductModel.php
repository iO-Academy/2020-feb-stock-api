<?php

namespace App\Models;

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
}
