<?php

namespace App\Factories;

use App\Controllers\AddProductController;
use Psr\Container\ContainerInterface;

class AddProductControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $productModel = $container->get('ProductModel');
        return new AddProductController($productModel);
    }
}
