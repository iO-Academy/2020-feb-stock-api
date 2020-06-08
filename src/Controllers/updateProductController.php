<?php


namespace App\Controllers;


use App\Abstracts\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class updateProductController extends Controller
{
    private $productModel;

    /**
     * updateProductController constructor.
     * @param $productModel
     */
    public function __construct($productModel)
    {
        $this->productModel = $productModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $productData = $request->getParsedBody()['product'];

        try {
            $product = new ProductEntity(
                $productData['sku'],
                $productData['name'],
                $productData['price'],
                $productData['stock']
            );

        } catch(\Throwable $e) {
            $responseData = [
                'success' => false,
                'msg' => $e->getMessage(),
                'data' => []
            ];
        }
    }

}