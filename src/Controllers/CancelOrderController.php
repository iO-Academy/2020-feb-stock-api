<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CancelOrderController extends Controller
{
    private $orderModel;

    /**
     * CancelOrderController constructor.
     * @param $orderModel
     */
    public function __construct($orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $responseData = [
            'success' => false,
            'message' => '',
            'data' => []
        ];

//        $orderNumber = SkuOrderValidator::validateSkuAndOrderNumber($args['orderNumber']);
        $orderNumber = $args['orderNumber'];

        if ($orderNumber) {
            try {
                $cancelOrderSuccess = $this->orderModel->cancelOrder($orderNumber);

                print_r($cancelOrderSuccess);

                $responseData['success'] = true;
                $responseData['message'] = 'Order cancelled successfully.';

                return $this->respondWithJson($response, $responseData, 200);

            } catch (\Throwable $e) {
                $responseData['message'] = 'Oops! Something went wrong; please try again.';

                return $this->respondWithJson($response, $responseData, 500);
            }
        }
        $responseData['message'] = 'Invalid order number. Please try again.';

        return $this->respondWithJson($response, $responseData, 400);
    }
}
