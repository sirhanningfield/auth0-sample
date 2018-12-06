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
            throw new Exception("Ledger already exists", 9999);
        }
    }

    private function createLedger($request)
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
            throw new Exception("Ledger already exists", 9999);
        }
        return $ledger;
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
            // validate the incoming request
            $validator = Validator::make($request->all(), [
                "name" => "required|string",
                "address" => "sometimes|string",
                "product"  => "required|integer",
                "serial"  => "sometimes|string",
                "number"  => "sometimes|string",
                "business_id"  => "sometimes|string",
            ]);

            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }


            // if ledger exists
            $this->checkLedgerExists($request);

            
            // Create new ledger
            $ledger = $this->createLedger($request);

            return new CompanyFile($ledger);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
