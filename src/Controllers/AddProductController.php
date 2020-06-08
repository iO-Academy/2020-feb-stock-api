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
                $newProductData['stock']);

        } catch (\Throwable $e) {
            $responseData = [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];

            $response->getBody()->write(json_encode($responseData));
            $response->withStatus(400);

            return $response->withHeader('Content-Type', 'application/json');
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
                $response->getBody()->write(json_encode($responseData));
                $response->withStatus(400);

                return $response->withHeader('Content-Type', 'application/json');

            } else {
                $query_success = $this->productModel->addProduct($newProduct);

                if ($query_success) {
                    $responseData = [
                        'success' => true,
                        'message' =>
                            'Product successfully added.',
                        'data' => []
                    ];
                    $response->getBody()->write(json_encode($responseData));
                    $response->withStatus(200);

                    return $response->withHeader('Content-Type', 'application/json');

                }
                $responseData = [
                    'success' => false,
                    'message' =>
                        'Could not add product please try again.',
                    'data' => []
                ];
                $response->getBody()->write(json_encode($responseData));
                $response->withStatus(500);

                return $response->withHeader('Content-Type', 'application/json');
            }

        } catch (\Throwable $e) {
            $responseData = [
                'success' => false,
                'message' => 'Oops! Something went wrong. Please try again later.',
                'data' => []
            ];
            $response->getBody()->write(json_encode($responseData));
            $response->withStatus(500);

            return $response->withHeader('Content-Type', 'application/json');
        }
    }
}
