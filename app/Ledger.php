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

    public static function exists($serial = null, $number = null, $businessId = null )
    {
        $ledger = [];
        if (isset($serial) && isset($number)) {
            $ledger = Ledger::where('serial', '=', $serial)->where('number', '=', $number)->get();
        } elseif (isset($request->business_id)) {
            $ledger = Ledger::where('business_id', '=', $businessId)->get();
        }

        if (count($ledger) > 0) {
            return true;
        }
        return false;
    }

}
