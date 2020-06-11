<?php

namespace App\Factories;

use App\Controllers\CancelOrderController;
use Psr\Container\ContainerInterface;

class CancelOrderControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $orderModel = $container->get('OrderModel');
        return new CancelOrderController($orderModel);
    }
}
