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

    /**
     * returns an array of all the orders in the DB with the products ordered as well or false if it fails.
     * @return array|false
     */
    public function getAllOrders()
    {
        $ordersPdo = $this->db->query('SELECT `orderNumber` ,
                                    `customerEmail`,
                                    `shippingAddress1`,
                                    `shippingAddress2`,
                                    `shippingCity`,
                                    `shippingPostcode`,
                                    `shippingCountry` 
                                FROM `orders`');
        $orders = $ordersPdo->fetchAll();

        foreach ($orders as $key=>$order) {
            $query = $this->db->prepare('SELECT `sku`, `volumeOrdered` 
                                        FROM `orderedProducts` 
                                        WHERE `orderNumber` = ?;');
            $queryCheck = $query->execute([$order['orderNumber']]);

            if (!$queryCheck) {
                return false;
            }

            $products = $query->fetchAll();
            $orders[$key]['products'] = $products;
        }

        return $orders;
    }
}
