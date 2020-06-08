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

        $responseData = [
            'success' => false,
            'message' => '',
            'data' => []
        ];

        try {
            $newProduct = new ProductEntity(
                $newProductData['sku'],
                $newProductData['name'],
                $newProductData['price'],
                $newProductData['stockLevel']);

        } catch (\Throwable $e) {
            $responseData['message']= $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $productExists = $this->productModel->checkProductExists($newProduct->getSku());

            if ($productExists) {
                $responseData['message']=
                    'This product already exists in the database. Either update the old product or use a new SKU.';

                return $this->respondWithJson($response, $responseData, 400);

            } else {
                $query_success = $this->productModel->addProduct($newProduct);

                if ($query_success) {
                    $responseData['success'] = true;
                    $responseData['message'] = 'Product successfully added.';

                    return $this->respondWithJson($response, $responseData, 200);
                }
                $responseData['message']= 'Could not add product please try again.';

                return $this->respondWithJson($response, $responseData, 500);
            }

        } catch (\Throwable $e) {
            $responseData['message']= 'Oops! Something went wrong. Please try again later.';

            return $this->respondWithJson($response, $responseData, 500);
        }
    }
}
