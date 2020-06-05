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
        $newProductData = $request->getParsedBody();
        $responseData = [
            'code' => 400,
            'success' => false,
            'msg' => '',
            'data' => []
        ];

        try {
            $newProduct = new ProductEntity(
                $newProductData['sku'],
                $newProductData['name'],
                $newProductData['price'],
                $newProductData['stock']);

            try {
                $queryResponse = $this->productModel->addProduct($newProduct);

                $responseData = [
                    'code' => 200,
                    'success' => $queryResponse,
                    'msg' => 'Product successfully added.',
                    'data' => []
                ];

            } catch(\Throwable $e) {
                $responseData['msg'] = $e;
            }

        } catch (\Throwable $e) {
            $responseData['msg'] = $e;
        }
        
        return $response;
    }
}
