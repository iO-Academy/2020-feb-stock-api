<?php

namespace App\Models;

use App\Interfaces\OrderModelInterface;

class OrderModel implements OrderModelInterface
{
    private $db;

    /**
     * OrderModel constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addOrder(OrderEntityInterface $orderEntity)
    {
        $order = [
            'orderNumber' => $orderEntity->getOrderNumber(),
            'customerEmail' => $orderEntity->getCustomerEmail(),
            'shippingAddress1' => $orderEntity->getShippingAddress1(),
            'shippingAddress2' => $orderEntity->getShippingAddress2(),
            'shippingCity' => $orderEntity->getShippingCity(),
            'shippingPostcode' => $orderEntity->getShippingPostcode(),
            'shippingCountry' => $orderEntity->getShippingCountry()
        ];

        $orderedProducts = $orderEntity->getProducts();

        $this->db->beginTransaction();

        $orderQuery = $this->db->prepare("INSERT INTO `orders`
                                        (`orderNumber`,
                                        `customerEmail`,
                                        `shippingAddress1`,
                                        `shippingAddress2`,
                                        `shippingCity`,
                                        `shippingPostcode`,
                                        `shippingCountry`)
                                        VALUES (:orderNumber,
                                                :customerEmail,
                                                :shippingAddress1,
                                                :shippingAddress2,
                                                :shippingCity,
                                                :shippingPostcode,
                                                :shippingCountry)");

        $orderQueryResult = $orderQuery->execute($order);

        foreach($orderedProducts as $product) {
            $productList[] = [$product['newStockLevel'], $product['sku']];
            $linkTableSql[] = '("' . $order['orderNumber'] .'", "' . $product['sku'] . '", ' . $product['volumeOrdered'] . ')';
            $productQuery = $this->db->prepare("UPDATE `products` 
                                                    SET `stockLevel` = ?
                                                    WHERE `sku` = ?");

            $productQueryResult = $productQuery->execute([$product['newStockLevel'], $product['sku']]);
        }

        $linkTableQuery = $this->db->prepare("INSERT INTO `orderedProducts`
                                                  (`orderNumber`, `sku`, `volumeOrdered`) 
                                                  VALUES ". implode(",", $linkTableSql));

        $linkTableQueryResult = $linkTableQuery->execute();

        if ($orderQueryResult && $productQueryResult && $linkTableQueryResult) {
            $this->db->commit();
            return true;
        }

        $this->db->rollback();

        return false;
    }
}
