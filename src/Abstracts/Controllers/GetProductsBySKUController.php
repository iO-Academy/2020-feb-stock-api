<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Interfaces\ProductModelInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetProductsBySKUController extends Controller
{
    private $productModel;

    /**
     * GetProductsController constructor.
     * @param $productModel
     */
    public function __construct(ProductModelInterface $productModel)
    {
        $this->productModel = $productModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $sku = $request->getParsedBody() ['sku'];
        $sku = $args['sku'];

        try {
            $products = $this->productModel->getAllProductsBySKU();
        } catch (\Throwable $e) {
            $data = ['success' => false,
                'message' => 'Something went wrong, please try again later',
                'data' => []];
            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }

        $message = $products ? 'All products returned' : 'There are no products in the database';

        $data = ['success' => true,
            'message' => $message,
            'data' => $products];
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
