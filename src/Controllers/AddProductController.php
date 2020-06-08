<?php


namespace App\Controllers;


use App\Abstracts\Controller;
use App\Entities\ProductEntity;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AddProductController extends Controller
{
    private $productModel;

    /**
     * AddProductController constructor.
     * @param $productModel
     */
    public function __construct($productModel)
    {
        $this->productModel = $productModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $newProductData = $request->getParsedBody()['product'];

        try {
            $newProduct = new ProductEntity(
                $newProductData['sku'],
                $newProductData['name'],
                $newProductData['price'],
                $newProductData['stockLevel']);

        } catch (\Throwable $e) {
            $responseData = [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $productExists = $this->productModel->checkProductExists($newProduct->getSku());

            if ($productExists) {
                $responseData = [
                    'success' => false,
                    'message' =>
                        'This product already exists in the database. Either update the old product or use a new SKU.',
                    'data' => []
                ];

                return $this->respondWithJson($response, $responseData, 400);

            } else {
                $query_success = $this->productModel->addProduct($newProduct);

                if ($query_success) {
                    $responseData = [
                        'success' => true,
                        'message' =>
                            'Product successfully added.',
                        'data' => []
                    ];

                    return $this->respondWithJson($response, $responseData, 200);
                }
                $responseData = [
                    'success' => false,
                    'message' =>
                        'Could not add product please try again.',
                    'data' => []
                ];

                return $this->respondWithJson($response, $responseData, 500);
            }

        } catch (\Throwable $e) {
            $responseData = [
                'success' => false,
                'message' => 'Oops! Something went wrong. Please try again later.',
                'data' => []
            ];

            return $this->respondWithJson($response, $responseData, 500);
        }
    }
}
