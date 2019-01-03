<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('serial/{serial}', function ($serial) {
    //
});

Route::get('serial/{serial}/file/{fid}', 'API\SerialsController@show')->where('fid', '[0-9]{1,3}');
Route::patch('serial/{serial}/file/{fid}', 'API\SerialsController@update')->where('fid', '[0-9]{1,3}');

Route::post('ledger/onboard', 'API\FilesController@onboard');
Route::post('ledger/retrieve', 'API\FilesController@getLedgerId');
Route::post('events', 'API\EventsController@postEventNotification');


//Email
Route::post('payroll/payrun/{id}/notification', 'API\EmailController@create');

//Employee
Route::get('employee','API\EmployeesController@index');
Route::get('employee/{id}','API\EmployeesController@show');
Route::post('employee/serial/{serial}/file/{fid}', 'API\EmployeesController@create')->where('fid', '[0-9]{1,3}')->where('serial', '[0-9]{1,3}');
Route::patch('employee/{id}','API\EmployeesController@update');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//User
Route::post('user/ledger/{ledger}','API\UsersController@create');

//Auth0
Route::get('/login', 'Auth\Auth0IndexController@login')->name( 'login' );

Route::get('/public', function (Request $request) {
    return response()->json(["message" => "Public endpoint! Access token not required."]);
});

Route::get('/userInfo', 'API\UsersController@getUserInfo')->middleware('jwt');

Route::get('/private-scoped', function (Request $request) {
    return response()->json([
        "message" => "Valid Private-scoped endpoint Access Token."
    ]);
})->middleware('check.scope:read:messages');

