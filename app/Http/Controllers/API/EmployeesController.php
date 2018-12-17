<?php

namespace App\Http\Controllers\API;

use App\Employee;
use App\CompanyFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Employee as EmployeeResource;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EmployeeResource::collection(Employee::paginate(25));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $serial, $file)
    {
        //Handle Trial CompanyFile (No Serial, No File ID)
        //Assign a trial serial and fileid
          if (($serial == 0) && ($file == 0))
          {
            $serial = "9912345678";
            $file = "4";
          }
          $company_file = CompanyFile::where('serial', $serial)->where('number', $file)->firstOrFail();

          $file = Employee::create([
                  'companyid' => $company_file->id, 'no' => $request->input('data.no'),
                  'name' => $request->input('data.name'),'idno' => $request->input('data.idno'),
                  'birth' => $request->input('data.birth'),'gender' => $request->input('data.gender'),
                  'passportno' => $request->input('data.passportno'),'jobtitle' => $request->input('data.jobtitle'),
                  'salary' => $request->input('data.salary')
                  ]);
          return new EmployeeResource($file);
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
     * @param  \App\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show($employee)
    {
        $file = Employee::where('id', $employee)->firstOrFail();
        return new EmployeeResource($file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employee)
    {
        $file = Employee::where('id', $employee)->firstOrFail();

        $file->no = $request->input('data.no');
        $file->name = $request->input('data.name');
        $file->idno = $request->input('data.idno');
        $file->birth = $request->input('data.birth');
        $file->gender = $request->input('data.gender');
        $file->passportno = $request->input('data.passportno');
        $file->jobtitle = $request->input('data.jobtitle');
        $file->salary = $request->input('data.salary');

        $file->save();

        return new EmployeeResource($file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
