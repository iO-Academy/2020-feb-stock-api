<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Interfaces\ProductModelInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetProductsController extends Controller
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
        try {
            $products = $this->productModel->getAllProducts();
        } catch (\Throwable $e) {
            $data = ['success' => false,
                'message' => 'Something went wrong, please try again later',
                'data' => []];

            return $this->respondWithJson($response, $data, 500);
        }

        $message = $products ? 'All products returned' : 'There are no products in the database';

        $data = ['success' => true,
            'message' => $message,
            'data' => $products];

        return $this->respondWithJson($response, $data);
    }
}
