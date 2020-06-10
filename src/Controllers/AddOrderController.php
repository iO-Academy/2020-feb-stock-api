<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Entities\OrderEntity;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AddOrderController extends Controller
{
    private $orderModel;

    /**
     * AddOrderController constructor.
     * @param $orderModel
     */
    public function __construct($orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {

        // dummy data to check if db query is working
        $products = [
            [
                'sku' => 'UGGBBPUR06',
                'volumeOrdered' => 2,
                'newStockLevel' => 10
            ],
            [
                'sku' => 'UGGBBPUR07',
                'volumeOrdered' => 4,
                'newStockLevel' => 8
            ]
        ];

        $orderEntity = new OrderEntity(
            'TESTORDER06',
            'test@example.com',
            '16 Test Lane',
            '',
            'Teston',
            'AB12 BA21',
            'UK',
            $products
        );

        $queryResponse = $this->orderModel->addOrder($orderEntity);

        var_dump($queryResponse);
        return $response;
    }
}
