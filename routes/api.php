<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Ramsey\Uuid\Uuid;


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

Route::get('serial/{serial}/file/{fid}', function ($serial, $fid) {
    return [
        "start" => URL::temporarySignedRoute(
            'file.start', now()->addSeconds(20),
            ['cfileid' => Uuid::uuid4()->toString()]
        )
    ];
})->where('fid', '[0-9]{1,3}');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
