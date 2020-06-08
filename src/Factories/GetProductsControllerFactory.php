<?php

namespace App\Factories;

use App\Controllers\GetProductsController;
use Psr\Container\ContainerInterface;

class GetProductsControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $productModel = $container->get('ProductModel');
        return new GetProductsController($productModel);
    }
}
