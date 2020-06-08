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
        try {
            $deleteProduct = $this->productModel->deleteProductBySku($args['sku']);

            if ($deleteProduct) {
                $responseData['message'] =
                    "Product successfully deleted";

                return $this->respondWithJson($response, $responseData, 200);

            } else {
                $responseData['message'] =
                    "Product couldn't be deleted at this time, please try again";

                return $this->respondWithJson($response, $responseData, 400);
            }

        } catch(\Throwable $e) {
            $responseData['message'] =
                "Something went wrong, please try again later";

            return $this->respondWithJson($response, $responseData, 500);
        }
    }
}