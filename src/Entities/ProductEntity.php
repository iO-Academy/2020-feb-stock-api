<?php

namespace App\Entities;

use App\Validators\PriceValidator;
use App\Validators\SkuOrderValidator;
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

        $this->sanitiseData();
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

    private function sanitiseData()
    {
        $this->sku = SkuOrderValidator::validateSkuAndOrder($this->sku);

        $this->name = StringValidator::sanitiseString($this->name);
        $this->name = StringValidator::validateExistsAndLength($this->name, 255);

        $this->price = StringValidator::validateExistsAndLength($this->price, 255);
        $this->price = PriceValidator::validatePrice($this->price);

        $this->stockLevel = StringValidator::validateExistsAndLength($this->stockLevel, 11);
        $this->stockLevel = StockLevelValidator::validateStockLevel($this->stockLevel);
    }
}
