<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Entities\OrderEntity;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AddOrderController extends Controller
{
    private $orderModel;
    private $productModel;

    /**
     * AddOrderController constructor.
     * @param $orderModel
     */
    public function __construct($orderModel)
    {
        $this->orderModel = $orderModel;
        $this->productModel = $productModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $responseData = [
            'success' => false,
            'message' => '',
            'data' => []
        ];
        
        $sku = $args['sku'];

        try {
            $sku = SKUValidator::validateSKU($sku);

        } catch (\Throwable $e) {
            $responseData['message'] = $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $returnedProduct = $this->productModel->getProductBySKU($sku);

        } catch (\Throwable $e) {
            $responseData['message'] = 'Something went wrong, please try again later';

            return $this->respondWithJson($response, $responseData, 500);
        }

        if ($returnedProduct) {
            try {
                $newOrder = new OrderEntity(
                    $newOrderData['orderNumber'],
                    $newOrderData['customerEmail'],
                    $newOrderData['shippingAddress1'],
                    $newOrderData['shippingAddress2'],
                    $newOrderData['shippingCity'],
                    $newOrderData['shippingPostcode'],
                    $newOrderData['shippingCountry'],
                    $newOrderData['products']);

            } catch (\Throwable $e) {
                $responseData['message'] = $e->getMessage();

                return $this->respondWithJson($response, $responseData, 400);
            }
            $query_success = $this->orderModel->addOrder($newOrder);

            if ($query_success) {
                $responseData['success'] = true;
                $responseData['message'] = 'Order successfully added.';

                return $this->respondWithJson($response, $responseData, 200);
            }

            $responseData['message'] = 'An error occurred, could not add order, please try again later.';

            return $this->respondWithJson($response, $responseData, 500);
        }
    }
}
