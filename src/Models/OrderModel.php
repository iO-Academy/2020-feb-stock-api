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
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * returns an array of all the orders in the DB with the products ordered as well or false if it fails.
     * @return array|false
     */
    public function getAllOrders()
    {
        $this->db->beginTransaction();

        $ordersQuery = $this->db->prepare('SELECT `orderNumber` ,
                                    `customerEmail`,
                                    `shippingAddress1`,
                                    `shippingAddress2`,
                                    `shippingCity`,
                                    `shippingPostcode`,
                                    `shippingCountry` 
                                FROM `orders`');
        $ordersQueryCheck = $ordersQuery->execute();
        if(!$ordersQueryCheck){
            $this->db->rollback();
            return false;
        }

        $orders = $ordersQuery->fetchAll();

        foreach ($orders as $i=>$order) {
            $productQuery = $this->db->prepare('SELECT `sku`, `volumeOrdered` 
                                        FROM `orderedProducts` 
                                        WHERE `orderNumber` = ?;');
            $productQueryCheck = $productQuery->execute([$order['orderNumber']]);
            if (!$productQueryCheck){
                $this->db->rollback();
                return false;
            }

            $products = $productQuery->fetchAll();
            $orders[$i]['products'] = $products;
        }

        $this->db->commit();
        return $orders;
    }
}
