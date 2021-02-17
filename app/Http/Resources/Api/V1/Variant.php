<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class Variant extends JsonResource
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
            'size' => $this->option_1,
            'color' => $this->option_2,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'sku' => $this->sku,
        ];
    }
}
