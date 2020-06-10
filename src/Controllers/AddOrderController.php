<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Entities\OrderEntity;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AddOrderController extends Controller
{
    private $orderModel;

    /**
     * AddOrderController constructor.
     * @param $orderModel
     */
    public function __construct($orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        return $response;
    }
}
