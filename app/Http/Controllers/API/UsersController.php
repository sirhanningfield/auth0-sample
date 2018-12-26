<?php

namespace App\Http\Controllers\API;

use Validator;
use App\User;
use App\UserLedger;
use App\Ledger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function create(Request $request, $ledger)
    {
        // return response()->json(['message' => $ledger], 200); 
        try
        {
            //Validate auth_id + email is not nullable
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'auth_id' => 'required|string',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 404);
            }
    
            //Not to insert when auth_id already exist 
            if (User::where('auth_id', $request->input('auth_id'))->count() <= 0)
            {
                //Create user record
                $user = User::create([
                    'name' => $request->input('name'), 'email' => $request->input('email'),
                    'auth_id' => $request->input('auth_id')
                    ]);    
                
                //Create user-ledger record
                $user_ledger = UserLedger::create([
                    'user_id' => $user->id, 'ledger_id' => $ledger
                ]);

                return response()->json(['message' => 'Users record created successfully.'], 200);
            }
            else
            {
                return response()->json(['message' => 'Users record already exists.'], 404);
            }
        }
        catch (Exception $e)
        {
          return response()->json(['message' => 'Users record created failed.'], 500);
        }             
    }

    public function getUserInfo(Request $request)
    {
        try {
            // get user auth_id from request
            list($tag,$auth_id) = explode("|",$request->user->sub);

            // Get the user details
            $user = User::where('auth_id',$auth_id)->first();
            if(!$user){
                return response()->json(['error' => 'User not found.'], 404);
            }

            $userLedgers = [];
            foreach ($user->ledgers as $ledger) {
                $newledger = Ledger::where('id',$ledger->ledger_id)->first();
                $userLedgers[] = [
                    'name' => $newledger->name,
                    'ledger_id' => $ledger->ledger_id
                ];
            }

            $userInfo = [
                'name' => $user->name,
                'email' => $user->email,
                'auth_id' => $user->auth_id,
                'ledgers' => $userLedgers
            ];

            return response()->json(['user' => $userInfo], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        
    }
}
