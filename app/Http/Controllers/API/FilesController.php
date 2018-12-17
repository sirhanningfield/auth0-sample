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
        try {
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
                return GlobalService::returnError($validator->errors()->first(), 400);
            }

            // check request params
            if (!$this->validParams($request)) {
                return GlobalService::returnError("Invalid parameters", 400);
            }

            // if ledger exists
            if (Ledger::exists($request->serial, $request->number, $request->business_id)) {
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

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode() ? $e->getCode() : null);
        }

    }


    private function validParams($request)
    {
        print_r($request->all());
        exit;
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
}
