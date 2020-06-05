<?php

namespace App\Models;

use App\Collections\ProductCollection;
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

    public function getAllProducts()
    {
        $query = $this->db->query('SELECT `sku`, `name`, `price`, `stockLevel` FROM `products`;');
        return new ProductCollection($query->fetchAll(\PDO::FETCH_FUNC, "App\Utilities\ProductMapper::ProductEntity"));
    }
}
