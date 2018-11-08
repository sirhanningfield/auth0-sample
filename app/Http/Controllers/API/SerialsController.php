<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyFile as CompanyFileResource;

class SerialsController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $serial
     * @param  string  $file
     * @return \Illuminate\Http\Response
     */
    public function show($serial, $file)
    {
        $file = \App\Ledger::where('serial', $serial)->where('number', $file)->firstOrFail();
        return new CompanyFileResource($file);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $serial
     * @param  string  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $serial, $file)
    {
        $file = \App\Ledger::where('serial', $serial)->where('number', $file)->firstOrFail();
    
        // We must manually fill in json fields as ->only() cannot address json data.
        // $file->update($request->only(['data.address', 'data.name']));
        if ($request->filled('data.address')) {
            $file->address = $request->input('data.address');
        }
            
        if ($request->filled('data.name')) {
            $file->name = $request->input('data.name');
        }
            
        $file->save();

        return new CompanyFileResource($file);
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
