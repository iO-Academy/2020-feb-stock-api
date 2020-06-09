<?php

namespace App\Entities;

use App\Interfaces\ProductEntityInterface;

class ProductEntity implements ProductEntityInterface
{
    private $orderNumber;
    private $customerEmail;
    private $shippingAddress1;
    private $shippingAddress2;
    private $shippingCity;
    private $shippingPostcode;
    private $shippingCountry;

    /**
     * OrderEntity constructor.
     * @param $orderNumber
     * @param $customerEmail
     * @param $shippingAddress1
     * @param $shippingAddress2
     * @param $shippingCity
     * @param $shippingPostcode
     * @param $shippingCountry
     */
    public function __construct($orderNumber, $customerEmail, $shippingAddress1, $shippingAddress2, $shippingCity, $shippingPostcode, $shippingCountry)
    {
        $this->orderNumber = $orderNumber;
        $this->customerEmail = $customerEmail;
        $this->shippingAddress1 = $shippingAddress1;
        $this->shippingAddress2 = $shippingAddress2;
        $this->shippingCity = $shippingCity;
        $this->shippingPostcode = $shippingPostcode;
        $this->shippingCountry = $shippingCountry;
    }
}
