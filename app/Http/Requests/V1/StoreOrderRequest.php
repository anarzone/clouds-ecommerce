<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class StoreOrderRequest extends FormRequest
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
            'cart_id' => 'required|numeric',
            'address_id' => 'required|numeric',
            'note' => 'nullable|string',
            'subtotal' => 'required|numeric',
            'delivery' => 'required|numeric',
            'gift_card' => 'required|numeric',
            'reward' => 'required|numeric',
            'debit_card' => 'required|numeric',
            'total' => 'required|numeric',
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
