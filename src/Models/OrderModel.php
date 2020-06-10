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

        foreach ($orders as $key=>$order){
            $query = $this->db->prepare('SELECT `orderNumber` , `sku`, `volumeOrdered` 
                                        FROM `orderedProducts` 
                                        WHERE `orderNumber` = ?;');
            $queryCheck = $query->execute([$order['orderNumber']]);
            if($queryCheck) {
                $products = $query->fetchAll();
                $orders[$key]['products'] = $products;
            } else {
                return false;
            }
        }

        return $orders;
    }
}
