<?php

namespace App\Factories;

use App\Controllers\AddOrderController;
use Psr\Container\ContainerInterface;

class AddOrderControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $orderModel = $container->get('OrderModel');
        $productModel = $container->get('ProductModel');
        return new AddOrderController($orderModel, $productModel);
    }
}
