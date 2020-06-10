<?php

namespace App\Validators;

class EmailValidator extends StringValidator
{
    /**
     * Ensures valid email
     * @param string $email
     * @return mixed
     * @throws \Exception
     */
    public static function validateEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        } else {
            throw new \Exception('Invalid email');
        }
    }
}
