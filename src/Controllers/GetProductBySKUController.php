<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Interfaces\ProductModelInterface;
use App\Validators\SKUValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetProductBySKUController extends Controller
{
    private $productModel;

    /**
     * GetProductBySKUController constructor.
     * @param $productModel
     */
    public function __construct(ProductModelInterface $productModel)
    {
        $this->productModel = $productModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $sku = $args['sku'];

        try {
            $sku = SKUValidator::validateSKU($sku);

        } catch (\Throwable $e) {
            $responseData['message'] = $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $productExists = $this->productModel->checkProductExists($sku);
            
            if ($productExists) {
                $getProduct = $this->productModel->getProductBySKU($sku);
            
                if ($productExists) {
                    $responseData = ['success' => true,
                    'message' => 'Requested product returned',
                    'data' => [$getProduct]];

                    return $this->respondWithJson($response, $responseData, 200);

                } else {
                    $responseData = ['success' => false,
                    'message' => 'Product could not be returned at this time',
                    'data' => [$getProduct]];

                    return $this->respondWithJson($response, $responseData, 500);
                }
            }

            $responseData = ['success' => false,
            'message' => 'There are no products of this SKU in the database',
            'data' => [$getProduct]];

            return $this->respondWithJson($response, $responseData, 400);

        } catch (\Throwable $e) {
            $responseData = ['success' => false,
                'message' => 'Something went wrong, please try again later',
                'data' => [$getProduct]];

            return $this->respondWithJson($response, $responseData, 500);
        }      
    }
}
