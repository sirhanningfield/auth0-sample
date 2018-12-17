<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule ;
use Illuminate\Support\Facades\Validator;

class ValidNotificationEvent implements Rule
{
    private $validator;
    
    public function passes($attribute, $value)
    {
        $validator = Validator::make($value,[
            "name" => "required|string",
            "provider" => "required|string",
            "source" => "sometimes"
        ]);
        if($validator->fails()){
            $this->validator = $validator;
            return false;
        }
        return true;
        
    }

    public function message()
    {
        return $this->validator->errors()->first();
    }
}
