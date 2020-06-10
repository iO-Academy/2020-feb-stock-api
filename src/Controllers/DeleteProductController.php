<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Interfaces\ProductModelInterface;
use App\Validators\SkuValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DeleteProductController extends Controller
{
    private $productModel;

    /**
     * DeleteProductController constructor.
     */
    public function __construct(ProductModelInterface $productModel)
    {
        $this->productModel = $productModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $sku = $args['sku'];

        $responseData = [
            'success' => false,
            'message' => '',
            'data' => []
        ];

        try {
            $sku = SKUValidator::validateSKU($sku);

        } catch (\Throwable $e) {
            $responseData['message'] = $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $exists = $this->productModel->checkProductExists($sku);

            if ($exists) {
                $deleteProduct = $this->productModel->deleteProductBySku($sku);

                if ($deleteProduct){
                    $responseData['success'] = true;
                    $responseData['message'] =
                        "Product successfully deleted";

                    return $this->respondWithJson($response, $responseData, 200);

                } else {
                    $responseData['message'] =
                        "Product couldn't be deleted at this time, please try again";

                    return $this->respondWithJson($response, $responseData, 500);
                }
            }

            $responseData['message'] =
                "Product doesn't exist, therefore couldn't be deleted, please try again";

            return $this->respondWithJson($response, $responseData, 400);

        } catch(\Throwable $e) {
            $responseData['message'] =
                "Something went wrong, please try again later";

            return $this->respondWithJson($response, $responseData, 500);
        }
    }
}
