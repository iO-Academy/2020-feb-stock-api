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

    public function testValidateExistsAndLengthErrorDoesNotExist()
    {
        $maxCharacterLength = 30;
        $name = '';
        $this->expectExceptionMessage('An input string does not exist or is too long');  
        StringValidator::validateExistsAndLength($name, $maxCharacterLength);    
    }

    public function testValidateExistsAndLengthErrorTooLong()
    {
        $maxCharacterLength = 30;
        $name = 'Best stocks from best stocks ever land of eternal stocks if you do not buy these i will hunt you down and make you to buy them';
        $this->expectExceptionMessage('An input string does not exist or is too long');  
        StringValidator::validateExistsAndLength($name, $maxCharacterLength);      
    }

    public function testValidateExistsAndLengthMalformed()
    {
        $maxCharacterLength = 30;
        $name = [11, 22, 33];
        $this->expectException(\TypeError::class);  
        StringValidator::validateExistsAndLength($name, $maxCharacterLength);    
    }
}
