<?php


namespace App\Entities;

use App\Validators\NameValidator;
use App\Validators\PriceValidator;
use App\Validators\SkuValidator;
use App\Validators\StockLevelValidator;
use App\Validators\StringValidator;

use App\Interfaces\ProductEntityInterface;

class ProductEntity implements ProductEntityInterface
{
    private $sku;
    private $name;
    private $price;
    private $stockLevel;

    /**
     * ProductEntity constructor.
     */
    public function __construct($sku, $name, $price, $stockLevel)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->stockLevel = $stockLevel;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getStockLevel()
    {
        return $this->stockLevel;
    }
}
