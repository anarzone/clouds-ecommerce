<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class StoreProductRequest extends FormRequest
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
            'sku' => 'required',
            'variants' => 'required|array',
            'variants.*.quantity' => 'required',
            'colors' => 'required',
            'sizes' => 'required',
            'price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'quantity' => 'required',
            'brand_id' => 'required',
            'product_type_id' => 'required',
            'image_ids' => 'required',
            'main_image' => $this->request->has('main_image') ? 'required' : 'nullable',
            'categoryData' => 'required|array',
            'categoryData.*.category_id' => 'required|numeric',
            'categoryData.*.gender_type_id' => 'required|numeric',
            'categoryData.*.age_type_id' => 'required|numeric',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'message' => "The given data is invalid",
            'statusCode' =>  Response::HTTP_UNPROCESSABLE_ENTITY,
            "errors" => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
        throw new ValidationException($validator, $response);
    }
}
