<?php


namespace App\Collections;


use App\Interfaces\ProductEntityInterface;

class ProductCollection
{
    private $products;

    /**
     * ProductCollection constructor.
     * @param $products
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }


    private function checkProducts(array $products)
    {
        foreach ($products as $product) {
            if (!($product instanceof ProductEntityInterface)) {
                throw new \Exception('Array must only contain Objects that implement ProductEntityInterface ');
            }
        }
    }

}