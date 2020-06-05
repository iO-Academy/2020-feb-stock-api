<?php

namespace Portal\Validators;

class NameValidator extends StringValidator
{
    public static function sanitiseString($validateData)
    {
        $clean = filter_var($validateData, FILTER_SANITIZE_STRING);
        $clean = trim($clean);
        return $clean;
    }
}
