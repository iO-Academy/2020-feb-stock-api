<?php

namespace Tests\Validators;

use App\Validators\skuValidator;
use Tests\TestCase;

class skuValidatorTest extends TestCase
{
    public function testValidateSkuSuccess()
    {
        $sku = 'AAABBCCC11';
        $result = skuValidator::validateSku($sku);
        $this->assertEquals('AAABBCCC11', $result);
    }

    public function testValidateSKUFailure()
    {
        $sku = '@£$%';
        $this->expectException(\Exception::class);     
        $result = skuValidator::validateSku($sku); 
    }

    public function testValidateSKUMalformed()
    {
        $sku = ['AAABBCCC11'];
        $this->expectException(\TypeError::class);
        $result = skuValidator::validateSku($sku);
    }
}
