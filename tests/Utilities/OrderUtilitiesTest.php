<?php

namespace Tests\Utilities;

use App\Utilities\OrderUtilities;

class OrderUtilitiesTest extends \PHPUnit\Framework\TestCase
{
    public function testCalcAdjustedStockLevelSuccess()
    {
        $orderedProducts = [
            [
                "sku" => "abcdef123456",
                "volumeOrdered" => 1
            ],
            [
                "sku" => "abcdef123457",
                "volumeOrdered" => 2
            ]
        ];

        $productStockLevels = [
            [
                "sku" => "abcdef123456",
                "stockLevel" => 5
            ],
            [
                "sku" => "abcdef123457",
                "stockLevel" => 4
            ]
        ];

        $expected = [
            [
                "sku" => "abcdef123456",
                "volumeOrdered" => 1,
                "newStockLevel" => 4
            ],
            [
                "sku" => "abcdef123457",
                "volumeOrdered" => 2,
                "newStockLevel" => 2
            ]
        ];

        $actual = OrderUtilities::calcAdjustedStockLevels($orderedProducts, $productStockLevels);
        $this->assertEquals($expected, $actual);
    }
    public function testCalcAdjustedStockLevelMalformed()
    {
        $orderedProducts = '4321';

        $productStockLevels = [
            [
                "sku" => "abcdef123456",
                "stockLevel" => 5
            ],
            [
                "sku" => "abcdef123457",
                "stockLevel" => 4
            ]
        ];

        $this->expectException(\TypeError::class);
        OrderUtilities::calcAdjustedStockLevels($orderedProducts, $productStockLevels);
    }
}
