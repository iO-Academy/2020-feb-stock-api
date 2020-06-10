<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Interfaces\OrderModelInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetOrdersController extends Controller
{
    private $orderModel;

    /**
     * GetOrdersController constructor.
     * @param $orderModel
     */
    public function __construct(OrderModelInterface $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        // TODO: Implement __invoke() method.
    }
}
