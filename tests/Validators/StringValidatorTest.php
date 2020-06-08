<?php

namespace Tests\Validators;

use App\Validators\StringValidator;
use Tests\TestCase;

class StringValidatorTest extends TestCase
{
    public function testValidateExistsAndLengthSuccess()
    {
        $maxCharacterLength = 30;
        $name = 'Loads of stocks';
        $result = StringValidator::validateExistsAndLength($name, $maxCharacterLength);
        $this->assertEquals('Loads of stocks', $result);
    }

    public function testValidateExistsAndLengthFailure()
    {
        $maxCharacterLength = 30;
        $name = '';
        $this->expectException(\Exception::class);  
        $result = StringValidator::validateExistsAndLength($name, $maxCharacterLength);    
    }

    public function testValidateExistsAndLengthMalformed()
    {
        $maxCharacterLength = 30;
        $name = [11, 22, 33];
        $this->expectException(\TypeError::class);  
        $result = StringValidator::validateExistsAndLength($name, $maxCharacterLength);    
    }
}
