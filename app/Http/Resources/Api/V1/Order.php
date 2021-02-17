<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'customer_id' => $this->customer_id,
            'shipping_address' => $this->shipping_address,
            'shipping_floor' => $this->shipping_floor,
            'shipping_country' => $this->shipping_country,
            'shipping_city' => $this->shipping_city,
            'status' => $this->status,
            'tax' => $this->tax,
            'subtotal' => $this->subtotal,
            'delivery' => $this->delivery,
            'total' => $this->total,
            'reward' => $this->reward,
            'gift_cart' => $this->gift_cart,
            'debit_cart' => $this->debit_cart,
            'note' => $this->note,
        ];
    }
}
