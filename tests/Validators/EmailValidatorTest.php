<?php

namespace Tests\Validators;

use App\Validators\EmailValidator;
use Tests\TestCase;

class EmailValidatorTest extends TestCase
{
    public function testValidateEmailSuccess()
    {
        $email = 'example@test.com';
        $result = EmailValidator::validateEmail($email);
        $this->assertEquals('example@test.com', $result);
    }

    public function testValidateEmailFailure()
    {
        $email = 'example @ test.com';
        $this->expectExceptionMessage('Invalid email');
        EmailValidator::validateEmail($email);
    }

    public function testValidateEmailMalformed()
    {
        $email = ['example@test.com'];
        $this->expectException(\TypeError::class);
        EmailValidator::validateEmail($email);
    }
}