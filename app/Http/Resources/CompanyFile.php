<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class CompanyFile extends JsonResource
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
            'ledger_id' => $this->id,
            'product' => $this->product,
            'serial' => $this->serial,
            'number' => $this->number,
            'business_id' => $this->business_id,
            'name' => $this->name,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'links' => [
                "portal" => [
                    "start" => URL::temporarySignedRoute(
                        'file.start', now()->addMinutes(5),
                        ['cfileid' => $this->id]
                    ),
                ]
            ],
        ];
    }
}
