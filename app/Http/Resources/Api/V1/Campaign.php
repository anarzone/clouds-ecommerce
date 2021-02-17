<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class Campaign extends JsonResource
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
            'name' => $this->translation()->title,
            'description' => $this->translation()->description,
            'cover' => env('APP_URL').'/storage/'.$this->cover,
            'rateType' => $this->rate_type,
            'rate' => $this->rate,
            'campaignType' => $this->campaign_type,
        ];
    }
}
