<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class StoreCustomerRequest extends FormRequest
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
            'firstname' => 'required',
            'lastname' => 'required',
            'birthdate' => 'required|date',
            'interested_in' => 'nullable',
            'email' => 'required|email|unique:users,email,'.auth('api')->user()->id.',id',
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
