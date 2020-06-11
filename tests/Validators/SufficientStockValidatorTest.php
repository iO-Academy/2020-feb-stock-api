<?php

namespace Tests\Validators;

use App\Validators\SufficientStockValidator;

class SufficientStockValidatorTest extends \PHPUnit\Framework\TestCase
{
    public function testCheckSufficientStockSuccess()
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

        $actual = SufficientStockValidator::checkSufficientStock($orderedProducts, $productStockLevels);

        $this->assertEquals(true, $actual);
    }

    public function testCheckSufficientStockInvalidSKU()
    {
        $orderedProducts = [
            [
                "sku" => "abcdef123456",
                "volumeOrdered" => 1
            ],
            [
                "sku" => "abcdLPOJ",
                "volumeOrdered" => 2
            ]
        ];

        $productStockLevels = [
            [
                "sku" => "abcdef123456",
                "stockLevel" => 5
            ]
        ];

        $this->expectExceptionMessage('Some SKUs provided do not exist in DB');
        SufficientStockValidator::checkSufficientStock($orderedProducts, $productStockLevels);
    }

    public function testCheckSufficientStockLowStock()
    {
        $orderedProducts = [
            [
                "sku" => "abcdef123456",
                "volumeOrdered" => 1
            ],
            [
                "sku" => "abcdef123457",
                "volumeOrdered" => 6
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

        $this->expectExceptionMessage("Volume ordered for product with SKU (abcdef123457) is higher than current stock");
        SufficientStockValidator::checkSufficientStock($orderedProducts, $productStockLevels);
    }

    public function testCheckSufficientStockVolumeOrderedZero()
    {
        $orderedProducts = [
            [
                "sku" => "abcdef123456",
                "volumeOrdered" => 1
            ],
            [
                "sku" => "abcdef123457",
                "volumeOrdered" => 0
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

        $this->expectExceptionMessage("Volume ordered for product with SKU (abcdef123457) must be larger than 0");
        SufficientStockValidator::checkSufficientStock($orderedProducts, $productStockLevels);
    }
}
