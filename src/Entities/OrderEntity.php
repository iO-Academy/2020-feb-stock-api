<?php

namespace App\Entities;

use App\Interfaces\OrderEntityInterface;
use App\Validators\AddressTwoValidator;
use App\Validators\AddressValidator;
use App\Validators\CityValidator;
use App\Validators\CountryValidator;
use App\Validators\EmailValidator;
use App\Validators\OrderNumberValidator;
use App\Validators\PostcodeValidator;

class OrderEntity implements OrderEntityInterface
{
    private $orderNumber;
    private $customerEmail;
    private $shippingAddress1;
    private $shippingAddress2;
    private $shippingCity;
    private $shippingPostcode;
    private $shippingCountry;
    private $products;

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
    public function __construct($orderNumber, $customerEmail, $shippingAddress1, $shippingAddress2, $shippingCity, $shippingPostcode, $shippingCountry, $products)
    {
        $this->orderNumber = $orderNumber;
        $this->customerEmail = $customerEmail;
        $this->shippingAddress1 = $shippingAddress1;
        $this->shippingAddress2 = $shippingAddress2;
        $this->shippingCity = $shippingCity;
        $this->shippingPostcode = $shippingPostcode;
        $this->shippingCountry = $shippingCountry;
        $this->products = $products;

        $this->validateOrder();
    }

    /**
     * @return mixed
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @return mixed
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @return mixed
     */
    public function getShippingAddress1()
    {
        return $this->shippingAddress1;
    }

    /**
     * @return mixed
     */
    public function getShippingAddress2()
    {
        return $this->shippingAddress2;
    }

    /**
     * @return mixed
     */
    public function getShippingCity()
    {
        return $this->shippingCity;
    }

    /**
     * @return mixed
     */
    public function getShippingPostcode()
    {
        return $this->shippingPostcode;
    }

    /**
     * @return mixed
     */
    public function getShippingCountry()
    {
        return $this->shippingCountry;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    private function validateOrder()
    {
        $this->orderNumber = OrderNumberValidator::validateOrderNumber($this->orderNumber);
        $this->customerEmail = EmailValidator::validateEmail($this->customerEmail);
        $this->shippingAddress1 = AddressValidator::validateAddress($this->shippingAddress1);
        $this->shippingAddress2 = AddressTwoValidator::validateAddressTwo($this->shippingAddress2);
        $this->shippingCity = CityValidator::validateCity($this->shippingCity);
        $this->shippingPostcode = PostcodeValidator::validatePostcode($this->shippingPostcode);
        $this->shippingCountry = CountryValidator::validateCountry($this->shippingCountry);
    }
}
