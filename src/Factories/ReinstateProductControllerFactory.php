<?php

namespace App\Factories;

use App\Controllers\ReinstateProductController;
use Psr\Container\ContainerInterface;

class ReinstateProductControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $productModel = $container->get('ProductModel');
        return new ReinstateProductController($productModel);
    }
}
