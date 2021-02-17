<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|array',
            'name.*' => 'required|string',
            'genderTypes' => 'required|array',
            'genderTypes.*' => 'required',
            'ageTypes' => 'required|array',
            'ageTypes.*' => 'required',
            'slug' => 'required|string|unique:categories,id,'.$this->request->get('category_id'),
            'cover' => 'sometimes|image|mimes:jpg,jpeg,png',
            'parent_id' => 'nullable|numeric',
            'grid' => 'numeric'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Tələb olunan sahə.',
            'string' => 'Format yalnız text(string) ola bilər.',
            'unique' => 'Artıq istifadə edilib.',
            'image' => 'Şəkil formatında olmalıdır.',
            'mimes' => 'Şəkil formatı yalnışdır (jpeg, jpg, png olmalıdır)',
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
