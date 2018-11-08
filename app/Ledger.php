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
}
