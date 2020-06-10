<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Interfaces\OrderModelInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetOrdersController extends Controller
{
    private $orderModel;

    /**
     * GetOrdersController constructor.
     * @param $orderModel
     */
    public function __construct(OrderModelInterface $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $responseData = ['success' => false,
            'message' => 'Something went wrong, please try again later',
            'data' => []];

        try {
            $orders = $this->orderModel->getAllOrders();
        } catch (\Throwable $e){
            return $this->respondWithJson($response, $responseData, 500);
        }

        if (!$orders){
            return $this->respondWithJson($response, $responseData, 500);
        }

        $responseData = ['success' => true,
            'message' => 'All orders returned!',
            'data' => ['orders' => $orders]];

        return $this->respondWithJson($response, $responseData);
    }
}
