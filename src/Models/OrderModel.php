<?php

namespace App\Models;

use App\Interfaces\OrderEntityInterface;
use App\Interfaces\OrderModelInterface;

class OrderModel implements OrderModelInterface
{
    private $db;

    /**
     * OrderModel constructor.
     * 
     * @param $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Checks if order exists in Database
     *
     * @param string $orderNumber
     * @return array containing the existing order's orderNumber and deleted status.
     * @return false if order doesn't exist
     */
    public function checkOrderExists(string $orderNumber)
    {
        $query = $this->db->prepare("SELECT `orderNumber`, `deleted`, `completed` 
                                        FROM `orders` 
                                        WHERE `orderNumber` = ?");
        $query->execute([$orderNumber]);
        return $query->fetch();
    }

    /**
     * Adds an order to the Database which does the following in a transaction:
     *  - adds order into the orders table
     *  - adds products ordered into the productsOrdered linking table
     *  - updates products' stockLevels with newStockLevels after order volume is taken into account.
     *
     * @param OrderEntityInterface $orderEntity
     * @return bool depending on whether the transaction was successful or not.
     */
    public function addOrder(OrderEntityInterface $orderEntity): bool
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

        if (!$orderQueryResult) {
            $this->db->rollback();
            return false;
        }

        $linkTableSql = [];

        foreach ($orderedProducts as $product) {
            $linkTableSql[] = '("' . $order['orderNumber'] . '", "' . $product['sku'] . '", ' . $product['volumeOrdered'] . ')';
            $productQuery = $this->db->prepare("UPDATE `products` 
                                                    SET `stockLevel` = ?
                                                    WHERE `sku` = ?");

            $productQueryResult = $productQuery->execute([$product['newStockLevel'], $product['sku']]);

            if (!$productQueryResult) {
                $this->db->rollback();
                return false;
            }
        }
        $linkTableQuery = $this->db->prepare("INSERT INTO `orderedProducts`
                                                  (`orderNumber`, `sku`, `volumeOrdered`) 
                                                  VALUES " . implode(",", $linkTableSql));

        $linkTableQueryResult = $linkTableQuery->execute();

        if (!$linkTableQueryResult) {
            $this->db->rollback();
            return false;
        }
        $this->db->commit();

        return true;
    }

    /**
     * Cancels an order in the Database through the following transaction:
     *  - soft deletes order in the orders table
     *  - updates products' stockLevels with old stockLevel plus the relevant volumeOrdered from order.
     *
     * @param string $orderNumber
     * @return bool depending on whether the transaction was successful or not.
     */
    public function cancelOrder(string $orderNumber) {
        $this->db->beginTransaction();

        $cancelOrderQuery = $this->db->prepare("UPDATE `orders`
                                                    SET `deleted` = 1
                                                    WHERE `orderNumber` = ?");
        $cancelOrderQueryResult = $cancelOrderQuery->execute([$orderNumber]);

        if (!$cancelOrderQueryResult) {
            $this->db->rollback();
            return false;
        }

        $productsOrdered = $this->getOrderedProductsByOrderNumber($orderNumber);

        if (!$productsOrdered) {
            $this->db->rollback();
            return false;
        }

        foreach($productsOrdered as $product) {
            $restorePreviousProductStockLevelQuery = $this->db->prepare("UPDATE `products`
                                                                            SET `stockLevel` = `stockLevel` + ?
                                                                            WHERE `sku` = ?");
            $restorePreviousProductStockLevelQueryResult =
                $restorePreviousProductStockLevelQuery->execute([$product['volumeOrdered'], $product['sku']]);

            if (!$restorePreviousProductStockLevelQueryResult) {
                $this->db->rollback();
                return false;
            }
        }
        $this->db->commit();

        return true;
    }

    /**
     * returns the following based on $completed:
     * $completed = 0 -> all active orders
     * $completed = 1 -> all completed orders
     * $default = All orders
     *
     * @param $completed
     * @return array|false
     */
    public function getAllOrders($completed)
    {
        $this->db->beginTransaction();

        $stmt = 'SELECT `orderNumber` ,
                                    `customerEmail`,
                                    `shippingAddress1`,
                                    `shippingAddress2`,
                                    `shippingCity`,
                                    `shippingPostcode`,
                                    `shippingCountry`,
                                    `completed`
                                FROM `orders`
                                WHERE `deleted` = 0';

        if ($completed === 0 || $completed === 1){
            $stmt .= " AND `completed` = $completed";
        }

        $ordersQuery = $this->db->prepare($stmt);
        $ordersQueryCheck = $ordersQuery->execute();

        if (!$ordersQueryCheck) {
            $this->db->rollback();
            return false;
        }
        $orders = $ordersQuery->fetchAll();

        foreach ($orders as $i => $order) {
            $return = $this->getOrderedProductsByOrderNumber($order['orderNumber']);

            if ($return === false) {
                $this->db->rollback();
                return false;
            }

            $orders[$i]['products'] = $return;
        }

        $this->db->commit();
        return $orders;
    }

    /**
     * Gets the products ordered for the specified order number and returns them.
     *
     * @param string $orderNumber
     * @return array|false array of products ordered with their SKU and volumeOrdered or false if query failed.
     */
    private function getOrderedProductsByOrderNumber(string $orderNumber)
    {
        $query = $this->db->prepare('SELECT `sku`, `volumeOrdered` 
                                        FROM `orderedProducts` 
                                        WHERE `orderNumber` = ?;');
        $queryResult = $query->execute([$orderNumber]);

        if ($queryResult) {
            return $query->fetchAll();
        }

        return false;
    }
}
