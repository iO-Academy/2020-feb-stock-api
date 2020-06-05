<?php


namespace App\Entities;


use App\Interfaces\IProductEntity;

class ProductEntity implements IProductEntity
{
    private $sku;
    private $name;
    private $price;
    private $stockLevel;

    /**
     * ProductEntity constructor.
     * @param $sku
     * @param $name
     * @param $price
     * @param $stockLevel
     */
    public function __construct($sku, $name, $price, $stockLevel)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->stockLevel = $stockLevel;
    }
}
