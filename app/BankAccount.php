<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bank;

class BankAccount extends Model
{
    //

    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }

    public function ledger()
    {
        return $this->belongsTo('App\Ledger');
    }

    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }

    public function bankTransactions()
    {
        return $this->hasMany('App\BankTransaction');
    }
}
