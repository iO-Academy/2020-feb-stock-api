<?php

namespace Tests\Validators;

use App\Validators\skuValidator;
use Tests\TestCase;

class SkuValidatorTest extends TestCase
{
    public function testValidateSkuSuccess()
    {
        $sku = 'AAABBCCC11';
        $result = SkuValidator::validateSku($sku);
        $this->assertEquals('AAABBCCC11', $result);
    }

    public function testValidateSkuFailure()
    {
        $sku = '@£$%';
        $this->expectExceptionMessage('Invalid SKU');
        SkuValidator::validateSku($sku);
    }

    public function testValidateSkuMalformed()
    {
        $sku = ['AAABBCCC11'];
        $this->expectException(\TypeError::class);
        SkuValidator::validateSku($sku);
    }
}
