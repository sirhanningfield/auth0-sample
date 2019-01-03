<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Email;
use App\Jobs\sendEmail;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
      try
      {
        $email = new Email;
        $email->sendername = $request->input('data.email.sender_name');
        $email->senderemail = $request->input('data.email.sender_email');
        $email->receivername = $request->input('data.email.receiver_name');
        $email->receiveremail = $request->input('data.email.receiver_email');
        $email->paymonth = $request->input('data.email.pay_month');
        $email->payyear = $request->input('data.email.pay_year');
        $email->payfreq = $request->input('data.email.pay_freq');
        $email->paydesc = $request->input('data.email.pay_desc');
        $email->compname = $request->input('data.company.name');
        $email->attachment = $request->input('data.email.payslip');
        $email->save();

        sendEmail::dispatch($email);

        return response()->json(['status' => 'accepted'], 200);
      }
      catch (Exception $e)
      {
        return response()->json(['status' => 'failed'], 500);
      }
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
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function edit(Email $email)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Email $email)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        //
    }

}
