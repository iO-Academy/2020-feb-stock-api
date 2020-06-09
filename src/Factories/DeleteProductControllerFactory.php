<?php

namespace App\Factories;

use App\Controllers\DeleteProductController;
use Psr\Container\ContainerInterface;

class DeleteProductControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $productModel = $container->get('ProductModel');
        return new DeleteProductController($productModel);
    }
}
