<?php

namespace Tests\Validators;

use App\Validators\StockLevelValidator;
use Tests\TestCase;

class StockLevelValidatorTest extends TestCase
{
    public function testValidateStockLevelSuccess()
    {
        $stockLevel = '1234';
        $result = StockLevelValidator::validateStockLevel($stockLevel);
        $this->assertEquals('1234', $result);
    }

    public function testValidateStockLevelEmpty()
    {
        $stockLevel = '';
        $this->expectExceptionMessage('Must provide stock level and be max 11 characters long');
        StockLevelValidator::validateStockLevel($stockLevel);
    }
    public function testValidateStockLevelTooHigh()
    {
        $stockLevel = '4098530984908345';
        $this->expectExceptionMessage('Must provide stock level and be max 11 characters long');
        StockLevelValidator::validateStockLevel($stockLevel);
    }

    public function testValidateStockLevelFailure()
    {
        $stockLevel = 'ABCD';
        $this->expectExceptionMessage('Invalid stock level');
        StockLevelValidator::validateStockLevel($stockLevel); 
    }

    public function testValidateStockLevelMalformed()
    {
        $stockLevel = ['4321'];
        $this->expectException(\TypeError::class);
        StockLevelValidator::validateStockLevel($stockLevel);
    }
}
