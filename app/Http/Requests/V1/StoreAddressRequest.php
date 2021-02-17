<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class StoreAddressRequest extends FormRequest
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
            'address' => 'required|string',
            'country_id' => 'required',
            'city_id' => 'required',
            'post_code' => 'required',
            'floor' => 'required',
            'phone' => 'required'
        ];
    }


    public function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'message' => "The given data is invalid",
            'status' => config('statuses.error'),
            'statusCode' =>  Response::HTTP_UNPROCESSABLE_ENTITY,
            "errors" => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
        throw new ValidationException($validator, $response);
    }
}
