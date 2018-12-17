<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLedger extends Model
{
    protected $fillable = ['user_id','ledger_id'];

    public function ledger()
    {
        return $this->belongsTo('App\Ledger');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }    
}
