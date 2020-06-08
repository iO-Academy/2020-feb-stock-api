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

        try {
            $product = new ProductEntity(
                $args['sku'],
                $productData['name'],
                $productData['price'],
                $productData['stockLevel']
            );

        } catch(\Throwable $e) {
            $responseData = [
                'success' => false,
                'msg' => $e->getMessage(),
                'data' => []
            ];

            $response->getBody()->write(json_encode($responseData));
            $response->withStatus(400);

            return $response->withHeader('Content-Type', 'application-json');
        }

        try {
            $productExists = $this->productModel->checkProductExists($product->getSku());

            if($productExists) {
                $query_response = $this->productModel->updateProduct($product);

                if($query_response) {
                    $responseData = [
                        'success' => true,
                        'msg' => 'Product updated successfully',
                        'data' => []
                    ];

                    $response->getBody()->write(json_encode($responseData));
                    $response->withStatus(200);

                    return $response->withHeader('Content-Type', 'application-json');
                }
                $responseData = [
                    'success' => false,
                    'msg' => 'Could not update product; please try again.',
                    'data' => []
                ];

                $response->getBody()->write(json_encode($responseData));
                $response->withStatus(500);

                return $response->withHeader('Content-Type', 'application-json');
            }
            $responseData = [
                'success' => false,
                'msg' => 'Product does not exist in the database. Please add as a new product.',
                'data' => []
            ];

            $response->getBody()->write(json_encode($responseData));
            $response->withStatus(400);

            return $response->withHeader('Content-Type', 'application-json');

        } catch(\Throwable $e) {
            $responseData = [
                'success' => false,
                'msg' => 'Oops! Something went wrong; please try again later.',
                'data' => []
            ];

            $response->getBody()->write(json_encode($responseData));
            $response->withStatus(500);

            return $response->withHeader('Content-Type', 'application-json');
        }
    }
}
