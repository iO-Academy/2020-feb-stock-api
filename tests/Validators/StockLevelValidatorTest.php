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

    public function testValidateStockLevelFailure()
    {
        $stockLevel = 'ABCD';
        $this->expectException(\Exception::class);     
        $result = StockLevelValidator::validateStockLevel($stockLevel); 
    }

    public function testValidateStockLevelMalformed()
    {
        $stockLevel = ['4321'];
        $this->expectException(\TypeError::class);
        $result = StockLevelValidator::validateStockLevel($stockLevel);
    }
}
