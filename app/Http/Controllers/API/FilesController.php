<?php

namespace App\Http\Controllers\API;


use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Ledger;
use App\Http\Resources\CompanyFile;
use App\Http\Resources\Response;
use App\Http\Constants\Ledgers;
use App\Http\Services\GlobalService;
use App\Rules\ValidProductType;
use App\Rules\ValidPrameters;
use App\Exceptions\ValidatorException;


class FilesController extends Controller
{
    /**
     * Store a newly created Ledger in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function onboard(Request $request)
    {
        
        // validate the incoming request
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "address" => "nullable|string",
            "product"  => ["required","integer", new ValidProductType],
            "serial"  => "sometimes|string",
            "number"  => "sometimes|string",
            "business_id"  => "sometimes|string"
        ]);

        if ($validator->fails()) {
            // throw new ValidatorException($validator);
            return GlobalService::returnError($validator->errors()->first(), 400);
        }

        // check request params
        if (!$this->validParams($request)) {
            return GlobalService::returnError("Invalid parameters", 400);
        }

        // if ledger exists
        if (Ledger::exists($request)) {
            return GlobalService::returnError("Ledger already exists", 400);
        }

        // Create new ledger
        $ledger = new Ledger;
        $ledger->name = $request->name;
        $ledger->product = $request->product;
        $ledger->address = isset($request->address) ? $request->address : null;
        $ledger->serial = isset($request->serial) ? $request->serial : null;
        $ledger->number = isset($request->number) ? $request->number : null;
        $ledger->business_id = isset($request->business_id) ? $request->business_id : null;
        $ledger->status = true; // default status is true for new ledgers
        if (!$ledger->save()) {
            return GlobalService::returnError("Could not create ledger", 401);
        }

        return GlobalService::returnResponse($ledger);

    }


    private function validParams($request)
    {
        if ($request->product == Ledgers::TYPE_PREMIER) {
            if (!isset($request->serial) || !isset($request->number) || isset($request->business_id)) {
                return false;
            }
        } elseif ($request->product == Ledgers::TYPE_FINANCIO) {
            if (!isset($request->business_id) || isset($request->serial) || isset($request->number)) {
                return false;
            }
        }
        return true;
    }

    public function getLedgerId(Request $request){

        $ledger = null;
        
        // check request params
        if (!$this->validParams($request)) {
            return GlobalService::returnError("Invalid parameters", 400);
        }
    
        // check if exists
        if ($request->product == Ledgers::TYPE_PREMIER && isset($request->serial) && isset($request->number)) {
            
            $ledger = Ledger::exists($request);
        } elseif ($request->product == Ledgers::TYPE_FINANCIO && isset($request->business_id)) {
            $ledger = Ledger::exists($request);
        }
        $result = [
            'ledger_id' => $ledger->id,
            'serial' => $ledger->serial ? $ledger->serial : null,
            'number' => $ledger->number ? $ledger->number : null,
            'business_id' => $ledger->business_id ?  $ledger->business_id  : null
        ];
        if($ledger) return GlobalService::returnResponse($result);
        return GlobalService::returnError("Cannot find ledger", 404);
    }

}
