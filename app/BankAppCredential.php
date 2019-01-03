<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAppCredential extends Model
{
    //
    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }
}