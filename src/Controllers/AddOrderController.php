<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Entities\OrderEntity;
use App\Validators\SkuOrderValidator;
use App\Validators\StockLevelValidator;
use App\Validators\SufficientStockValidator;
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
    public function __construct($orderModel, $productModel)
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
        
        $newOrderData = $request->getParsedBody()['order'];

        $productArray = $newOrderData['products'];

        foreach ($productArray as $product) {
            $sku = SkuOrderValidator::validateSkuAndOrder($product['sku']);

            if ($sku) {
                try {
                    $productData = $this->productModel->getProductBySKU($sku);

                    if ($productData) {
                        $currentProductStock = $productData->getStockLevel();    
                        
                        $volumeOrdered = StockLevelValidator::validateStockLevel($product['volumeOrdered']);

                        if ($volumeOrdered) {
                            $sufficientStock = SufficientStockValidator::validateSufficientStock($currentProductStock, $volumeOrdered);

                            if (!$sufficientStock) {
                                $responseData['message'] = 'Insufficient stock for product ' . $sku . '. unable to process order.';

                                return $this->respondWithJson($response, $responseData, 400);
                            }

                            $newStockLevel = $currentProductStock - $volumeOrdered;

                            $productsForOrderEntity[] = [
                                'sku' => $sku,
                                'volumeOrdered' => $volumeOrdered,
                                'newStockLevel' => $newStockLevel
                            ];
                        }
                        $responseData['message'] = 'Invalid volume ordered for product ' . $sku . '. unable to process order.';

                        return $this->respondWithJson($response, $responseData, 400);
                    }
                } catch (\Throwable $e) {
                    $responseData['message'] = 'An error occurred, please try again later';

                    return $this->respondWithJson($response, $responseData, 500);
                }
            }
            $responseData['message'] = 'Invalid SKU for product ' . $sku . '. unable to process order.';

            return $this->respondWithJson($response, $responseData, 400);
        } 

        try {
            $newOrder = new OrderEntity(
                $newOrderData['orderNumber'],
                $newOrderData['customerEmail'],
                $newOrderData['shippingAddress1'],
                $newOrderData['shippingAddress2'],
                $newOrderData['shippingCity'],
                $newOrderData['shippingPostcode'],
                $newOrderData['shippingCountry'],
                $productsForOrderEntity
            );

        } catch (\Throwable $e) {
            $responseData['message'] = $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $query_success = $this->orderModel->addOrder($newOrder);

            if ($query_success) {
                $responseData['success'] = true;
                $responseData['message'] = 'Order successfully added.';

                return $this->respondWithJson($response, $responseData, 200);
            }

            $responseData['message'] = 'An error occurred, could not add order, please try again later.';

            return $this->respondWithJson($response, $responseData, 500);
        
        } catch (\Throwable $e) {
            $responseData['message'] = 'An error occurred, could not add order, please try again later.';

            return $this->respondWithJson($response, $responseData, 500);
        }
    }
}
