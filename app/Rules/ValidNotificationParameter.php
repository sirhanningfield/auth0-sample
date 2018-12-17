<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule ;
use Illuminate\Support\Facades\Validator;
use App\Rules\ValidISOFormat;

class ValidNotificationParameter implements Rule
{
    private $validator;

    public function passes($attribute, $value)
    {
        $validator = Validator::make($value,[
            "filename" => "required|string",
            "expiry" => ["required", new ValidISOFormat],
        ]);
        if($validator->fails()){
            $this->validator = $validator;
            return false;
        }
        return true;
        
    }

    public function message()
    {
        return ":attribute: ".$this->validator->errors()->first();
    }
}
