<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    //

    public function bankAccounts()
    {
        return $this->hasMany('App\BankAccount');
    }

    public function ledgers()
    {
        return $this->hasMany('App\LedgerBankCredential');
    }
}
