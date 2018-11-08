<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankTransaction extends Model
{
    //
    public function bankAccount()
    {
        return $this->belongsTo('App\BankAccount');
    }
}
