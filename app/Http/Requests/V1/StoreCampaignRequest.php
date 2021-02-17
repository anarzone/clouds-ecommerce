<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|array',
            'description' => 'required|array',
            'description.*.*' => 'required',
            'title  .*.*' => 'required',
            'rate_type' => 'required|numeric',
            'campaign_type' => 'required|numeric',
            'status' => 'required',
            'rate' => 'required|numeric',
            'product_ids' => 'required|array',
        ];
    }
}
