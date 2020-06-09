<?php

namespace App\Factories;

use App\Models\ProductModel;
use Psr\Container\ContainerInterface;

class ProductModelFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $db = $container->get('Database')->connect();
        return new ProductModel($db);
    }
}
