<?php

namespace Tests\Validators;

use App\Validators\PriceValidator;
use Tests\TestCase;

class PriceValidatorTest extends TestCase
{
    public function testValidatePriceSuccess()
    {
        $price = '12345';
        $result = PriceValidator::validatePrice($price);
        $this->assertEquals('12345', $result);
    }

    public function testValidatePriceFailure()
    {
        $price = 'ABCD';
        $this->expectException(\Exception::class);     
        $result = PriceValidator::validatePrice($price); 
    }

    public function testValidatePriceMalformed()
    {
        $price = [12345];
        $this->expectException(\TypeError::class);
        $result = PriceValidator::validatePrice($price);
    }
}
