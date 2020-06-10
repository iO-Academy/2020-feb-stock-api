<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Entities\OrderEntity;
use App\Interfaces\OrderModelInterface;
use App\Interfaces\ProductModelInterface;
use App\Utilities\OrderUtilities;
use App\Validators\SkuValidator;
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
     * @param OrderModelInterface $orderModel
     * @param ProductModelInterface $productModel
     */
    public function __construct(OrderModelInterface $orderModel, ProductModelInterface $productModel)
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
        $orderedProducts = $newOrderData['products'];

        $productSKUs = [];
        try {
            foreach ($orderedProducts as $orderedProduct) {
                $sku = SKUValidator::validateSku($orderedProduct['sku']);
                StockLevelValidator::validateStockLevel($orderedProduct['volumeOrdered']);
                $productSKUs[] = $sku;
            }
        } catch (\Throwable $e){
            $responseData['message'] = $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $productStockLevels = $this->productModel->getMultipleStockLevelsBySKUs($productSKUs);
        } catch (\Throwable $e) {
            $responseData['message'] = 'An error occurred, could not add order, please try again later.';

            return $this->respondWithJson($response, $responseData, 500);
        }

        try {
            SufficientStockValidator::checkSufficientStock($orderedProducts, $productStockLevels);

            $productsForOrderEntity = OrderUtilities::calcAdjustedStockLevels($orderedProducts, $productStockLevels);

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
