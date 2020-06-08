<?php

namespace Tests\Validators;

use App\Validators\StringValidator;
use Tests\TestCase;

class StringValidatorTest extends TestCase
{
    public function testValidateExistsAndLengthSuccess()
    {
        $characterLength = 30;
        $name = 'Loads of stocks';
        $result = StringValidator::validateExistsAndLength($name, $characterLength);
        $this->assertEquals('Loads of stocks', $result);
    }

    public function testValidateExistsAndLengthFailure()
    {
        $characterLength = 30;
        $name = '';
        $this->expectException(\Exception::class);  
        $result = StringValidator::validateExistsAndLength($name, $characterLength);    
    }

    public function testValidateExistsAndLengthMalformed()
    {
        $characterLength = 30;
        $name = [11, 22, 33];
        $this->expectException(\TypeError::class);  
        $result = StringValidator::validateExistsAndLength($name, $characterLength);    
    }
}
