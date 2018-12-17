<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class Employee extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
      return [
          'id' => $this->id,
          'companyid' => $this->companyid,
          'no' => $this->no,
          'name' => $this->name,
          'gender' => $this->gender,
          'birth' => $this->birth,
          'idno' => $this->idno,
          'passportno' => $this->passportno,
          'jobtitle' => $this->jobtitle,
          'salary' => $this->salary,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
      ];
  }
}
