<?php

namespace Tests\Validators;

use App\Validators\AddressValidator;
use Tests\TestCase;

class AddressValidatorTest extends TestCase
{
    public function testValidateAddressSuccess()
    {
        $address = '46 Old Mill Road';
        $result = AddressValidator::validateAddress($address);
        $this->assertEquals('46 Old Mill Road', $result);
    }

    public function testValidateAddressFailure()
    {
        $address = 'ABCDEF!';
        $this->expectExceptionMessage('Invalid address');
        AddressValidator::validateAddress($address);
    }

    public function testValidateAddressMalformed()
    {
        $address = [46, 'Old', 'Mill', 'Road'];
        $this->expectException(\TypeError::class);
        AddressValidator::validateAddress($address);
    }
}