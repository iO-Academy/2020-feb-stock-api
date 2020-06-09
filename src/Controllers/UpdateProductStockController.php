<?php


namespace App\Controllers;


use App\Abstracts\Controller;
use App\Validators\SKUValidator;
use App\Validators\StockLevelValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateProductStockController extends Controller
{
    private $productModel;

    /**
     * UpdateProductStockController constructor.
     * @param $productModel
     */
    public function __construct($productModel)
    {
        $this->productModel = $productModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $stockLevel = $request->getParsedBody()['product']['stockLevel'];
        $sku = $args['sku'];

        $responseData = [
            'success' => false,
            'message' => '',
            'data' => []
        ];

        try {
            $productData = [
                'sku' => SKUValidator::validateSKU($sku),
                'stockLevel' => StockLevelValidator::validateStockLevel($stockLevel)
            ];
        } catch (\Throwable $e) {
            $responseData['message'] = $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $productExists = $this->productModel->checkProductExists($productData['sku']);

            if ($productExists) {
                $updatedProductStock = $this->productModel->updateProductStock($productData);

                if ($updatedProductStock) {
                    $responseData['success'] = true;
                    $responseData['message'] = 'Successfully updated product\'s stock level.';

                    return $this->respondWithJson($response, $responseData, 200);
                }
                $responseData['message']= 'Could not update product\'s stock level. Please try again.';

                return $this->respondWithJson($response, $responseData, 500);
            }
            $responseData['message']=
                'The product does not exist in the database. Please add it as a new product.';

            return $this->respondWithJson($response, $responseData, 400);
        } catch (\Throwable $e) {
            $responseData['message']= 'Oops! Something went wrong. Please try again later.';

            return $this->respondWithJson($response, $responseData, 500);
        }
    }
}
