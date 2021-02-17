<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class Address extends JsonResource
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
            'address' => $this->address,
            'floor' => $this->floor,
            'country' => [
                'id' => $this->country->id,
                'name' => $this->country->name,
                'phone_code' => $this->country->phone_code,
            ],
            'city' => [
                'id' => $this->city->id,
                'name' => $this->city->name
            ],
            'phone' => $this->phone
        ];
    }
}
