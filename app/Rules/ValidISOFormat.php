<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule ;

class ValidISOFormat implements Rule
{
    public function passes($attribute, $value)
    {
        $format =  \DateTime::ATOM;
        $d = \DateTime::createFromFormat($format, $value);
        
        if(!($d && $d->format($format) == $value)){
            return false;
        }
        return true;
        
    }

    public function message()
    {
        return "incorrect date format";
    }
}
