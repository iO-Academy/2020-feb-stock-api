<?php


namespace App\Controllers;


class updateProductController
{
    private $productModel;

    /**
     * updateProductController constructor.
     * @param $productModel
     */
    public function __construct($productModel)
    {
        $this->productModel = $productModel;
    }

    public function __invoke()
    {
        
    }
}