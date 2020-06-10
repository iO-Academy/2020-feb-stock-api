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
                $exists = $this->orderModel->checkOrderExists($orderNumber);

                if ($exists) {
                    $cancelOrderSuccess = $this->orderModel->cancelOrder($orderNumber);

                    if ($cancelOrderSuccess) {
                        $responseData['success'] = true;
                        $responseData['message'] = 'Order cancelled successfully.';

                        return $this->respondWithJson($response, $responseData, 200);
                    }
                    $responseData['message'] = 'Could not cancel order. Please try again.';

                    return $this->respondWithJson($response, $responseData, 500);
                }

                $responseData['message'] =
                    "Order doesn't exist, therefore couldn't be deleted, please try again";

                return $this->respondWithJson($response, $responseData, 400);

            } catch (\Throwable $e) {
                $responseData['message'] = 'Oops! Something went wrong; please try again.';

                return $this->respondWithJson($response, $responseData, 500);
            }
        }
        $responseData['message'] = 'Invalid order number. Please try again.';

        return $this->respondWithJson($response, $responseData, 400);
    }
}
