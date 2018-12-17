<?php

namespace App\Exceptions;

use Exception;

class ValidatorException extends Exception
{
    //
    private $validator ;
    private $response;
    private $errorCode;

    public function __construct($validator)
    {
        $this->validator = $validator;
    }

    public function report(){
        $this->response = [
            'status' => 0,
            'err_msg' => $this->validator->errors()->first(),
            'err_code' => 400
        ];
    }

    public function render(){
        return response()->json($this->response, 400);
    }
}
