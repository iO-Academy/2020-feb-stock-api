<?php


namespace App\Controllers;


use App\Abstracts\Controller;
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
        return $response;
    }
}
