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
                $productExists = $this->productModel->checkProductExists($newProduct);

                if($productExists) {
                    $responseData['code'] = 400;
                    $responseData['msg'] = 'This product already exists in the database. 
                    Either update the old product or use a new SKU.';

                } else {
                    $queryResponse = $this->productModel->addProduct($newProduct);

                    $responseData = [
                        'code' => 200,
                        'success' => $queryResponse,
                        'msg' => 'Product successfully added.',
                    ];
                }

            } catch(\Throwable $e) {
                $responseData['code'] = 500;
                $responseData['msg'] = 'Oops! Something went wrong. Please try again later.';
            }

        } catch (\Throwable $e) {
            $responseData['msg'] = $e;
        }

        $response->getBody()->write(json_encode($responseData));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
