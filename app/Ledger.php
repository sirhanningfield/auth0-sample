<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Behaviours\Uuids;

class Ledger extends Model
{
    use Uuids;

    protected $fillable = ['serial', 'number', 'address'];

    public $incrementing = false;


    public function bankAccounts()
    {
        return $this->hasMany('App\BankAccount');
    }

    public function bankCredentials()
    {
        return $this->hasMany('App\LedgerBankCredential');
    }

    public static function exists($request)
    {
        $ledger = null;
        if (isset($request->serial) && isset($request->number)) {
            $ledger = Ledger::where('serial', '=', $request->serial)->where('number', '=', $request->number)->first();
        } elseif (isset($request->business_id)) {
            $ledger = Ledger::where('business_id', '=', $request->businessId)->first();
        }
        
        if ($ledger) {
            return $ledger;
        }
        return false;
    }

}
