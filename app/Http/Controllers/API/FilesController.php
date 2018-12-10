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

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    private function checkLedgerExists($request)
    {
        $ledger = [];
        if (isset($request->serial) && isset($request->number)) {
            $ledger = Ledger::where('serial', '=', $request->serial)->where('number', '=', $request->number)->get();
        } elseif (isset($request->business_id)) {
            $ledger = Ledger::where('business_id', '=', $request->business_id)->get();
        }

        if (count($ledger) > 0) {
            return true;
        }
        return false;
    }

    private function createLedger($request, $result)
    {
        $ledger = new Ledger;
        $ledger->name = $request->name;
        $ledger->product = $request->product;
        $ledger->address = isset($request->address) ? $request->address : null;
        $ledger->serial = isset($request->serial) ? $request->serial : null;
        $ledger->number = isset($request->number) ? $request->number : null;
        $ledger->business_id = isset($request->business_id) ? $request->business_id : null;
        $ledger->status = true; // default status is true for new ledgers
        
        if (!$ledger->save()) {
            return false;
        }
        return $ledger;
    }

    private function productIsValid($request)
    {
        if ($request->product != Ledgers::TYPE_PREMIER && $request->product != Ledgers::TYPE_FINANCIO) {
            return false;
        }
        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addLedger(Request $request)
    {
        try {
            $result['status'] = 0;
            // validate the incoming request
            $validator = Validator::make($request->all(), [
                "name" => "required|string",
                "address" => "nullable|string",
                "product"  => "required|integer",
                "serial"  => "sometimes|string",
                "number"  => "sometimes|string",
                "business_id"  => "sometimes|string",
            ]);

            if ($validator->fails()) {
                $result['description'] = $validator->errors()->first();
                return response()->json($result, 400);
            }

            // check the request product type is valid
            if (!$this->productIsValid($request)) {
                $result['description'] = "Please enter a valid product code";
                return response()->json($result, 400);
            }

            // if ledger exists
            if ($this->checkLedgerExists($request)) {
                $result['description'] = "Ledger already exists";
                return response()->json($result, 400);
            }
  
            // Create new ledger
            $ledger = $this->createLedger($request, $result);

            $result = [
                'status' => $ledger ? 1 : 0,
                'description' => $ledger ? "Success" : "Failed to create a new ledger",
                'data' => $ledger ? new CompanyFile($ledger) : null
            ];

            return response()->json($result, 200);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode() ? $e->getCode() : null);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
