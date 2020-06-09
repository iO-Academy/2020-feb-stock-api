<?php


namespace App\Factories;


use App\Models\OrderModel;
use Psr\Container\ContainerInterface;

class OrderModelFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $db = $container->get('Database')::connect();
        return new OrderModel($db);
    }
}
