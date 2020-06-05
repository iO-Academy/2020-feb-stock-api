<?php

namespace Portal\Validators;

class NameValidator extends StringValidator
{
    public static function sanitiseString($validateData)
    {
        return trim(filter_var($validateData, FILTER_SANITIZE_STRING));
    }
}
