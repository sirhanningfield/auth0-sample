<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Behaviours\Uuids;
use App\CompanyFile;

class Employee extends Model
{
    use Uuids;

    protected $fillable = ['companyid','no','name','gender','birth','idno','passportno','jobtitle','salary'];

    public $incrementing = false;

    public function CompanyFile()
    {
      return $this->belongsTo(CompanyFile::class, 'companyid');
    }
}
