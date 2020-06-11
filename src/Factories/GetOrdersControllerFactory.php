<?php

namespace App\Factories;

use App\Controllers\GetOrdersController;
use Psr\Container\ContainerInterface;

class GetOrdersControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $orderModel = $container->get('OrderModel');
        return new GetOrdersController($orderModel);
    }
}
