<?php


namespace App\Factories;


use App\Controllers\UpdateProductStockController;
use Psr\Container\ContainerInterface;

class UpdateProductStockControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $productModel = $container->get('ProductModel');
        return new UpdateProductStockController($productModel);
    }
}
