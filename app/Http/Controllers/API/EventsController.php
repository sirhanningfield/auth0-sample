<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\GlobalService;
use Illuminate\Support\Facades\Validator;
class EventsController extends Controller
{
    /**
     * Funtion to recive event notification from partners (RHB)
     */
    public function postEventNotification(Request $request)
    {
        
        // validate incoming request parameters
        $validator = $this->validateRequest($request);
        if (isset($validator)) {
            return GlobalService::returnError($validator->errors()->first(), 400);
        }
        
        // validate date format for "_time" and "parameters->expiry"
        $timeFields = [$request->_time, $request->parameters['expiry']];
        if(!GlobalService::validateISO8601TimeFormat($timeFields)){
            return GlobalService::returnError("Invalid date format", 400);
        }

        
        // check event type and put a worker accordingly here ...

        return GlobalService::returnResponse();
        
         
    }


    private function validateRequest($request)
    {
        $params = ['request', 'event', 'parameters']; // The params that need to be validated
        foreach($params as $param){
            $validator = $this->validateParam($request,$param);
            if($validator){
                return $validator;
            }
        }
        return null;
    }

    public function validateParam($request, $param)
    {
        $validator = null;
        switch ($param) {
            case 'request':
                $validator = Validator::make($request->all(), [
                    "_time" => "required",
                    "event" => "required|array",
                    "parameters"  => "required|array"
                ]);
                break;
            case 'event':
                // validate event parameter
                $validator = Validator::make($request->event,[
                    "name" => "required|string",
                    "provider" => "required|string",
                    "source" => "sometimes"
                ]);
                break;
            case 'parameters':
                // validate parameters
                $validator = Validator::make($request->parameters,[
                    "filename" => "required|string",
                    "expiry" => "required",
                ]);
                break;
        }
        if ($validator && $validator->fails()) {
            return $validator;
        }
    }

}
