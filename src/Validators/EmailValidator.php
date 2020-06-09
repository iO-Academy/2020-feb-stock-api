<?php


namespace App\Validators;


class EmailValidator
{
    public function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        } else {
            throw new \Exception('Invalid email');
        }
    }
}