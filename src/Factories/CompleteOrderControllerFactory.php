<?php

namespace App\Factories;

use App\Controllers\CompleteOrderController;
use Psr\Container\ContainerInterface;

class CompleteOrderControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $orderModel = $container->get('OrderModel');
        return new CompleteOrderController($orderModel);
    }
}
