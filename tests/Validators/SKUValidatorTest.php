<?php

namespace Tests\Validators;

use App\Validators\SKUValidator;
use Tests\TestCase;

class SKUValidatorTest extends TestCase
{
    public function testValidateSKUSuccess()
    {
        $SKU = 'AAABBCCC11';
        $result = SKUValidator::validateSKU($SKU);
        $this->assertEquals('AAABBCCC11', $result);
    }

    public function testValidateSKUFailure()
    {
        $SKU = '@£$%';
        $this->expectException(\Exception::class);     
        $result = SKUValidator::validateSKU($SKU); 
    }

    public function testValidateSKUMalformed()
    {
        $SKU = ['AAABBCCC11'];
        $this->expectException(\TypeError::class);
        $result = SKUValidator::validateSKU($SKU);
    }
}