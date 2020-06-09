<?php


namespace App\Factories;


use App\Controllers\UpdateProductController;
use Psr\Container\ContainerInterface;

class UpdateProductControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $productModel = $container->get('ProductModel');

        return new updateProductController($productModel);
    }
}
