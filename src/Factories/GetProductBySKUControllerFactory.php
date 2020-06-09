<?php

namespace App\Factories;

use App\Controllers\GetProductBySKUController;
use Psr\Container\ContainerInterface;

class GetProductBySKUControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $productModel = $container->get('ProductModel');
        return new GetProductBySKUController($productModel);
    }
}
