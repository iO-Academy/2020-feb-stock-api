<?php


namespace App\Controllers;


use App\Abstracts\Controller;
use App\Interfaces\ProductModelInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DeleteProductController extends Controller
{
    private $productModel;

    /**
     * DeleteProductController constructor.
     */
    public function __construct(ProductModelInterface $productModel)
    {
        $this->productModel = $productModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        return $response;
    }
}