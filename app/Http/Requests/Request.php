<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Request extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function messages(): array
    {
        return [
            '*.required' => 'Field ":attribute" cannot be blank',
            '*.unique' => 'Field ":attribute" has already been taken',
            '*.min' => 'Field ":attribute" is too short',
            '*.max' => 'Field ":attribute" is too long',
            '*.string' => 'Field ":attribute" should be string',
            '*.numeric' => 'Field ":attribute" should be numeric',
            '*.integer' => 'Field ":attribute" should be integer',
            '*.boolean' => 'Field ":attribute" should be boolean',
            '*.array' => 'Field ":attribute" should be array',
            '*.image' => 'Field ":attribute" should be image',
            '*.exists' => 'Field ":attribute" does not exists',
        ];
    }
}
