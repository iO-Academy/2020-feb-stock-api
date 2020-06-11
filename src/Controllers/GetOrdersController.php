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

        $completedParam = $request->getQueryParams()['completed'] ?? null;
        $isCompleted = '';

        if (isset($completedParam)) {
            switch ($completedParam) {
                case '0':
                    $isCompleted = 0;
                    break;
                case '1':
                    $isCompleted = 1;
                    break;
                default:
                    $responseData['message'] = 'Invalid query parameter value please set completed to only a 1 or 0.';

                    return $this->respondWithJson($response, $responseData, 400);
            }
        }

        try {
            $orders = $this->orderModel->getAllOrders($isCompleted);
        } catch (\Throwable $e){
            return $this->respondWithJson($response, $responseData, 500);
        }

        if ($orders === false) {
            return $this->respondWithJson($response, $responseData, 500);
        }

        $responseData = ['success' => true,
            'message' => empty($orders) ? 'No orders are currently in the DB' : 'All orders returned',
            'data' => ['orders' => $orders]];

        return $this->respondWithJson($response, $responseData);
    }
}
