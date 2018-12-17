<?php

namespace App\Rules;
use App\Http\Constants\Ledgers;
use Illuminate\Contracts\Validation\Rule ;

class ValidProductType implements Rule
{
    public function passes($attribute, $value)
    {
        if ($value != Ledgers::TYPE_PREMIER && 
            $value != Ledgers::TYPE_FINANCIO) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return "Invalid Product type";
    }
}
