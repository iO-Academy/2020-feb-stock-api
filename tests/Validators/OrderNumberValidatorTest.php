<?php


namespace Tests\Validators;


use App\Validators\OrderNumberValidator;
use App\Validators\SkuValidator;

class OrderNumberValidatorTest
{
    public function testValidateOrderNumberSuccess()
    {
        $orderNumber = 'AAABBCCC11';
        $result = OrderNumberValidator::validateOrderNumber($orderNumber);
        $this->assertEquals('AAABBCCC11', $result);
    }

    public function testValidateOrderNumberFailure()
    {
        $orderNumber = '@£$%';
        $this->expectExceptionMessage('Invalid order number');
        OrderNumberValidator::validateOrderNumber($orderNumber);
    }

    public function testValidateOrderNumberMalformed()
    {
        $orderNumber = ['AAABBCCC11'];
        $this->expectException(\TypeError::class);
        OrderNumberValidator::validateOrderNumber($orderNumber);
    }
}
