<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Entities\ProductEntity;
use App\Interfaces\ProductModelInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateProductController extends Controller
{
    private $productModel;

    /**
     * UpdateProductController constructor.
     * @param $productModel
     */
    public function __construct(ProductModelInterface $productModel)
    {
        $this->productModel = $productModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $productData = $request->getParsedBody()['product'];

        $responseData = [
            'success' => false,
            'message' => '',
            'data' => []
        ];

        try {
            $product = new ProductEntity(
                $args['sku'],
                $productData['name'],
                $productData['price'],
                $productData['stockLevel']
            );

        } catch(\Throwable $e) {
            $responseData['message'] = $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $productExists = $this->productModel->checkProductExists($product->getSku());

            if($productExists && $productExists['deleted'] === "0") {
                $query_response = $this->productModel->updateProduct($product);

                if($query_response) {
                    $responseData['success'] = true;
                    $responseData['message'] = 'Product updated successfully.';

                    return $this->respondWithJson($response, $responseData, 200);
                }
                $responseData['message'] = 'Could not update product; please try again.';

                return $this->respondWithJson($response, $responseData, 500);
            }
            $responseData['message'] =
                'Product does not exist in the database. Please add as a new product.';

            return $this->respondWithJson($response, $responseData, 400);

        } catch(\Throwable $e) {
            $responseData['message'] = 'Oops! Something went wrong; please try again later.';

            return $this->respondWithJson($response, $responseData, 500);
        }
    }
}
