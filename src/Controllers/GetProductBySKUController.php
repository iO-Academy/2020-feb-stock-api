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
            $returnedProduct = $this->productModel->getProductBySKU($sku);
        } catch (\Throwable $e) {
            $responseData = ['success' => false,
                'message' => 'Something went wrong, please try again later',
                'data' => []];

            return $this->respondWithJson($response, $responseData, 500);
        }

        if ($returnedProduct) {
            $responseData = ['success' => true,
                'message' => 'Requested product returned',
                'data' => [$returnedProduct]];

            return $this->respondWithJson($response, $responseData, 200);
        }

        $responseData = ['success' => false,
            'message' => 'There are no products with this SKU in the database',
            'data' => []];

        return $this->respondWithJson($response, $responseData, 400);
    }
}
