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

        try {
            $productData = [
                'sku' => SKUValidator::validateSKU($sku),
                'stockLevel' => StockLevelValidator::validateStockLevel($stockLevel)
            ];
        } catch (\Throwable $e) {
            $responseData = [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];
            $response->getBody()->write(json_encode($responseData));

            return $response
                ->withHeader('Content-Type', 'application-json')
                ->withStatus(400);
        }

        try {
            $productExists = $this->productModel->checkProductExists($productData['sku']);

            if($productExists) {
                $updatedProductStock = $this->productModel->updateProductStock($productData);

                if($updatedProductStock) {
                    $responseData = [
                        'success' => true,
                        'message' => 'Successfully updated product\'s stock level.',
                        'data' => []
                    ];
                    $response->getBody()->write(json_encode($responseData));

                    return $response
                        ->withHeader('Content-Type', 'application-json')
                        ->withStatus(200);
                }
                $responseData = [
                    'success' => false,
                    'message' => 'Could not update product\'s stock level. Please try again.',
                    'data' => []
                ];
                $response->getBody()->write(json_encode($responseData));

                return $response
                    ->withHeader('Content-Type', 'application-json')
                    ->withStatus(500);
            }
            $responseData = [
                'success' => false,
                'message' => 'The product does not exist in the database. Please add it as a new product.',
                'data' => []
            ];
            $response->getBody()->write(json_encode($responseData));

            return $response
                ->withHeader('Content-Type', 'application-json')
                ->withStatus(400);

        } catch(\Throwable $e) {
            $responseData = [
                'success' => false,
                'message' => 'Oops! Something went wrong; please try again later.',
                'data' => []
            ];
            $response->getBody()->write(json_encode($responseData));

            return $response
                ->withHeader('Content-Type', 'application-json')
                ->withStatus(500);
        }
    }
}
