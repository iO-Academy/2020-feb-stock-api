<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Interfaces\OrderModelInterface;
use App\Validators\OrderNumberValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CancelOrderController extends Controller
{
    private $orderModel;

    /**
     * CancelOrderController constructor.
     * @param $orderModel
     */
    public function __construct(OrderModelInterface $orderModel)
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

            if (!$exists) {
                $responseData['message'] =
                    "Order doesn't exist, therefore couldn't be deleted, please try again";

                return $this->respondWithJson($response, $responseData, 400);
            }

            if ($exists['deleted'] === "1") {
                $responseData['message'] = 'Order has already been cancelled.';

                return $this->respondWithJson($response, $responseData, 400);

            } elseif ($exists['completed'] === "1") {
                $responseData['message'] = 'Order has already been completed. Cannot cancel.';

                return $this->respondWithJson($response, $responseData, 400);
            }

            $cancelOrderSuccess = $this->orderModel->cancelOrder($orderNumber);

            if ($cancelOrderSuccess) {
                $responseData['success'] = true;
                $responseData['message'] = 'Order cancelled successfully.';

                return $this->respondWithJson($response, $responseData, 200);
            }

            $responseData['message'] = 'Could not cancel order. Please try again.';

            return $this->respondWithJson($response, $responseData, 500);

        } catch (\Throwable $e) {
            $responseData['message'] = 'Oops! Something went wrong; please try again.';

            return $this->respondWithJson($response, $responseData, 500);
        }
    }
}
