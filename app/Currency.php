<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    //
    public function bankAccounts()
    {
        return $this->hasMany('App\BankAccount');
    }
}
