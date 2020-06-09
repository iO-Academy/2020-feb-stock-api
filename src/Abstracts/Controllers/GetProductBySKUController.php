<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Interfaces\ProductModelInterface;
use App\Validators\SkuValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetProductBySKUController extends Controller
{
    private $productModel;

    /**
     * GetProductsController constructor.
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
            $responseData = ['success' => false,
                'message' => 'Something went wrong, please try again later',
                'data' => []];

            return $this->respondWithJson($response, $responseData, 500);
        }

        try {
            $getProduct = $this->productModel->getProductBySKU();

        } catch (\Throwable $e) {
            $responseData = ['success' => false,
                'message' => 'Something went wrong, please try again later',
                'data' => []];

            return $this->respondWithJson($response, $responseData, 500);
        }

        $message = $getProduct ? 'Requested product returned' : 'There are no products of this SKU in the database';

        $responseData = ['success' => true,
            'message' => $message,
            'data' => $getProduct];

        return $this->respondWithJson($response, $responseData, 200);
    }
}
