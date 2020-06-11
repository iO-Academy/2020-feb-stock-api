<?php
declare(strict_types=1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $container = $app->getContainer();

    $app->addBodyParsingMiddleware();

    $app->get('/products', 'GetProductsController');
    $app->post('/products', 'AddProductController');

    $app->put('/products/{sku}', 'UpdateProductController');
    $app->get('/products/{sku}', 'GetProductBySKUController');
    $app->delete('/products/{sku}', 'DeleteProductController');

    $app->put('/products/stock/{sku}', 'UpdateProductStockController');
    $app->put('/products/undodelete/{sku}', 'ReinstateProductController');

    $app->post('/orders', 'AddOrderController');
    $app->get('/orders', 'GetOrdersController');

    $app->delete('/orders/{orderNumber}', 'CancelOrderController');
    $app->put('/orders/complete/{orderNumber}', 'CompleteOrderController');
};
