<?php

namespace App\Http\Services;

class GlobalService 
{
    static public function returnError($errorMessage, $errorCode)
    {
        $result = [
            'status' => 0,
            'error_msg' => $errorMessage,
            'error_cd' => $errorCode,
        ];
        return response()->json($result, $errorCode);
    }

    static public function validateISO8601TimeFormat(Array $timeFields)
    {
        $format = 'Y-m-d\TH:i:sP';
        foreach ($timeFields as $date) {
            $d = \DateTime::createFromFormat($format, $date);
            $valid = ($d && $d->format($format) == $date);
            if(!$valid){
                return false;
            };
        }
        return true;
    }

    static public function returnResponse($data = null)
    {
        $result = [
            'status' => 1,
            'msg' => "success",
            'data' => $data
        ];
        return response()->json($result,200);
    }

}
