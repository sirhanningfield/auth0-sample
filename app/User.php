<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name','email','auth_id'];

    protected $hidden = ['auth_id'];   
}
