<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Interfaces\ProductModelInterface;
use App\Validators\SkuValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReinstateProductController extends Controller
{
    private $productModel;

    /**
     * ReinstateProductController constructor.
     * @param ProductModelInterface $productModel
     */
    public function __construct(ProductModelInterface $productModel)
    {
        $this->productModel = $productModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $responseData = [
            'success' => false,
            'message' => '',
            'data' => []
        ];

        try {
            $sku = SkuValidator::validateSku($args['sku']);
        } catch (\Throwable $e) {
            $responseData['message'] = $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }
        $productExists = $this->productModel->checkProductExists($sku);

        if (!$productExists) {
            $responseData['message'] = 'Product SKU does not exist in database';

            return $this->respondWithJson($response, $responseData, 400);
        }
        $success_query = $this->productModel->reinstateProduct($sku);

        if ($success_query) {
            $responseData['success'] = true;
            $responseData['message'] = 'Product no longer deleted';

            return $this->respondWithJson($response, $responseData);
        }
        $responseData['message'] = 'Something went wrong, please try again later';

        return $this->respondWithJson($response, $responseData, 500);
    }
}
