<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LedgerBankCredential extends Model
{
    //

    public function ledger()
    {
        return $this->belongsTo('App\Ledger');
    }

    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }
}
