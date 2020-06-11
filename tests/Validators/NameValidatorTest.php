<?php

namespace Tests\Validators;

use App\Validators\NameValidator;

class NameValidatorTest extends \PHPUnit\Framework\TestCase
{
    public function testValidateNameSuccess()
    {
        $name = 'Product B';
        $result = NameValidator::validateName($name);
        $this->assertEquals('Product B', $result);
    }

    public function testValidateNameSuccess_Sanitize()
    {
        $name = ' Product B ';
        $result = NameValidator::validateName($name);
        $this->assertEquals('Product B', $result);
    }

    public function testValidateNameEmpty()
    {
        $name = '';
        $this->expectExceptionMessage('Must provide product name and be less than 255 characters');
        NameValidator::validateName($name);
    }

    public function testValidateNameTooHigh()
    {
        $name = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget metus a nunc laoreet porttitor at
         a nibh. Donec felis odio, faucibus eu eleifend placerat, rhoncus sed nibh. Duis purus ipsum, dictum vitae
          interdum id, rutrum eget nisl. rutrum eget nisl. ';
        $this->expectExceptionMessage('Must provide product name and be less than 255 characters');
        NameValidator::validateName($name);
    }

    public function testValidateNameMalformed()
    {
        $name = ['4321'];
        $this->expectException(\TypeError::class);
        NameValidator::validateName($name);
    }
}
