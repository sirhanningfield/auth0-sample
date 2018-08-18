<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Behaviours\Uuids;


class CompanyFile extends Model 
{
    use Uuids;

    protected $fillable = ['serial', 'number', 'address'];

    public $incrementing = false;
}
