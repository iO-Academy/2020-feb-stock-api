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
            'shippingAddress1' => $orderEntity->getCustomerEmail(),
            'shippingAddress2' => $orderEntity->getCustomerEmail(),
            'shippingCity' => $orderEntity->getCustomerEmail(),
            'shippingPostcode' => $orderEntity->getCustomerEmail(),
            'shippingCountry' => $orderEntity->getCustomerEmail()
        ];

        $orderedProducts = $orderEntity->getOrderedProducts();

        $this->db->beginTransaction();

        $orderQuery = $this->db->prepare("INSERT INTO `orders`
                                        (`orderNumber`, 
                                        `customerEmail`, 
                                        `shippingAddress1`, 
                                        `shippingAddress2`,
                                        `shippingCity`,
                                        `shippingPostcode`,
                                        `shippingCountry`,
                                        )
                                            VALUES (:orderNumber, 
                                                    :customerEmail, 
                                                    :shippingAddress1, 
                                                    :shippingAddress2,
                                                    :shippingCity,
                                                    :shippingPostcode,
                                                    :shippingCountry,)");

        $orderQueryResult = $orderQuery->execute($order);

        foreach($orderedProducts as $product) {
            $sql[] = '("' . $order['orderNumber'] .'", ' . $product['sku'] . '", ' . $product['volumeNumber'] . ')';
        }

        $linkTableQuery = $this->db->prepare("INSERT INTO `orderedProducts`
                                                  (`orderNumber`, `sku`, `volumeNumber`) 
                                                  VALUES ". implode(",", $sql));

        $this->db->commit();
        return true;
    }
}
