<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\GlobalService;
use App\Http\Resources\Date as DateResource;
use Illuminate\Support\Facades\Validator;
use App\EventNotification;
use Carbon\Carbon;
use App\Rules\validNotificationParameter;
use App\Rules\ValidNotificationEvent;
use App\Rules\ValidISOFormat;
use App\Exceptions\ValidatorException;


class EventsController extends Controller
{
    /**
     * Funtion to recive event notification from partners (RHB)
     */
    public function postEventNotification(Request $request)
    {
        
        // validate incoming request parameters
        $this->validateRequest($request);
        
        // Log the notification event
        if(!$this->logEventNotification($request)){
            return GlobalService::returnError("Cannot log notification", 400);
        }
        // check event type and put a worker accordingly here ...

        return GlobalService::returnResponse();
           
    }

    private function validateRequest($request)
    {
        
        $validator = Validator::make($request->all(), [
            "_time" => ["required", new ValidISOFormat],
            "event" => ["required","array", new ValidNotificationEvent],
            "parameters"  => ['required', 'array', new ValidNotificationParameter]
        ]);
        if($validator->fails()){
            throw new ValidatorException($validator);
        }
        
    }

    private function logEventNotification($request){
       
        $notification = new EventNotification;
        $notification->time = $this->toUTCdateTime($request->_time)['date'];
        $notification->time_tz = $this->toUTCdateTime($request->_time)['timezone'];
        $notification->event_name = $request->event['name'];
        $notification->provider = $request->event['provider'] ;
        $notification->source = $request->event['source'] ? $request->event['source'] : null;
        $notification->filename = $request->parameters['filename'];
        $notification->expiry = $this->toUTCdateTime($request->parameters['expiry'])['date'];
        $notification->expiry_tz = $this->toUTCdateTime($request->parameters['expiry'])['timezone'];
        if(!$notification->save()){
            return false;
        }
        return $notification;
    }

    /**
     * string $date ISO8601 date from the API request e.g. "2018-10-30T09:56:44+08:00"
     * 
     * @return string e.g. ""
     */
    private function toUTCdateTime($date){
        $format = \DateTime::ISO8601;
        $dateObj = new \DateTime();
        $dateTime = $dateObj->createFromFormat($format, $date);
        $returnDate = $dateTime->format('Y-m-d H:i:s');
        $timezone = $dateTime->getTimezone()->getName();
        return [
            'date' => $returnDate,
            'timezone' => $timezone
        ];
    }

    
}
