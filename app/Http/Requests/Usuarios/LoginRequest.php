<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login' => ['required', 'string'],
            'senha' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'login.required' => 'O campo login é obrigatório.',
            'login.string' => 'O campo login deve ser uma string.',
            'senha.required' => 'O campo senha é obrigatório.',
            'senha.string' => 'O campo senha deve ser uma string.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Falha na validação dos dados enviados',
            'errors' => $validator->errors()
        ], 422));
    }
}
