<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Validators\OrderNumberValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CompleteOrderController extends Controller
{
    private $orderModel;

    /**
     * CompleteOrderController constructor.
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

        try {
            $orderNumber = OrderNumberValidator::validateOrderNumber($args['orderNumber']);
        } catch (\Throwable $e) {
            $responseData['message'] = $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $exists = $this->orderModel->checkOrderExists($orderNumber);

            if (!$exists || $exists['deleted'] === "1") {
                $responseData['message'] =
                    "Order doesn't exist, therefore could not be marked as complete.";

                return $this->respondWithJson($response, $responseData, 400);
            }

            if ($exists['completed'] === "1") {
                $responseData['message'] = 'Order has already been completed.';

                return $this->respondWithJson($response, $responseData, 400);
            }

            $cancelOrderSuccess = $this->orderModel->completeOrder($orderNumber);

        } catch (\Throwable $e) {
            $responseData['message'] = 'Oops! Something went wrong; please try again.';

            return $this->respondWithJson($response, $responseData, 500);
        }

        if ($cancelOrderSuccess) {
            $responseData['success'] = true;
            $responseData['message'] = 'Order successfully marked as complete.';

            return $this->respondWithJson($response, $responseData, 200);
        }
        $responseData['message'] = 'Could not mark order as complete. Please try again.';

        return $this->respondWithJson($response, $responseData, 500);
    }
}
