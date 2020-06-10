<?php

namespace Tests\Validators;

use App\Validators\PriceValidator;
use Tests\TestCase;

class PriceValidatorTest extends TestCase
{
    public function testValidatePriceSuccess()
    {
        $price = '12345.55';
        $result = PriceValidator::validatePrice($price);
        $this->assertEquals('12345.55', $result);
    }

    public function testValidatePriceFailure_Letters()
    {
        $price = 'ABCD';
        $this->expectExceptionMessage('Invalid price');
        PriceValidator::validatePrice($price);
    }

    public function testValidatePriceFailure_InvalidPrice()
    {
        $price = '12345.555';
        $this->expectExceptionMessage('Invalid price');
        PriceValidator::validatePrice($price);
    }

    public function testValidatePriceEmpty()
    {
        $price = '';
        $this->expectExceptionMessage('Must provide price and be max 13 characters long');
        PriceValidator::validatePrice($price);
    }

    public function testValidatePriceTooHigh()
    {
        $price = '19817678629620';
        $this->expectExceptionMessage('Must provide price and be max 13 characters long');
        PriceValidator::validatePrice($price);
    }

    public function testValidatePriceMalformed()
    {
        $price = [12345];
        $this->expectException(\TypeError::class);
        PriceValidator::validatePrice($price);
    }
}
