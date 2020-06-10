<?php

namespace App\Entities;

use App\Validators\NameValidator;
use App\Validators\PriceValidator;
use App\Validators\SkuValidator;
use App\Validators\StockLevelValidator;
use App\Interfaces\ProductEntityInterface;

class ProductEntity implements ProductEntityInterface
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

        $this->validateProduct();
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

    private function validateProduct()
    {
        $this->sku = SkuValidator::validateSku($this->sku);
        $this->name = NameValidator::validateName($this->name);
        $this->price = PriceValidator::validatePrice($this->price);
        $this->stockLevel = StockLevelValidator::validateStockLevel($this->stockLevel);
    }
}
