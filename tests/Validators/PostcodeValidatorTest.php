<?php

namespace Tests\Validators;

use App\Validators\PostcodeValidator;
use Tests\TestCase;

class PostcodeValidatorTest extends TestCase
{
    public function testValidatePostcodeSuccess()
    {
        $postcode = 'SM5 7UP';
        $result = PostcodeValidator::validatePostcode($postcode);
        $this->assertEquals('SM5 7UP', $result);
    }

    public function testValidatePostcodeFailure()
    {
        $postcode = 'AB12 CD34';
        $this->expectExceptionMessage('Invalid postcode');
        PostcodeValidator::validatePostcode($postcode);
    }

    public function testValidatePostcodeMalformed()
    {
        $postcode = ['AB2 8UK'];
        $this->expectException(\TypeError::class);
        PostcodeValidator::validatePostcode($postcode);
    }
}
