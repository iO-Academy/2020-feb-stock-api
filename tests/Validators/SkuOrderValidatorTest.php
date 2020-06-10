<?php

namespace Tests\Validators;

use App\Validators\SkuOrderValidator;
use Tests\TestCase;

class SkuOrderValidatorTest extends TestCase
{
    public function testValidateSkuAndOrderSuccess()
    {
        $sku = 'AAABBCCC11';
        $result = SkuOrderValidator::validateSkuAndOrder($sku);
        $this->assertEquals('AAABBCCC11', $result);
    }

    public function testValidateSkuAndOrderFailure()
    {
        $sku = '@£$%';
        $this->expectExceptionMessage('Invalid input');
        SkuOrderValidator::validateSkuAndOrder($sku);
    }

    public function testValidateSkuAndOrderMalformed()
    {
        $sku = ['AAABBCCC11'];
        $this->expectException(\TypeError::class);
        SkuOrderValidator::validateSkuAndOrder($sku);
    }
}
